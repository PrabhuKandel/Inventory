<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Contact;
use App\Models\Product;
use App\Repositories\PurchaseSaleRepository;
use App\Http\Middleware\BranchAccessMiddleware;
use App\Http\Requests\PurchaseSaleRequest;
use App\Repositories\TranscationRepository;
use Illuminate\Support\Facades\DB;
use Exception;

//maintain code remaining ----

class PurchaseandSaleController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * 
   */
  private $purchaseSaleRepo;
  private $branch;
  private $type;
  private $transcationRepo;

  public function __construct(Request $request, PurchaseSaleRepository $purchaseSaleRepo, TranscationRepository $transcationRepo)
  {


    $this->middleware(BranchAccessMiddleware::class);
    $this->middleware('permission:view-purchase|view-sale|create-purchase|create-sale|edit-purchase|edit-sale|delete-purchase|delete-sale')->only('index');
    $this->middleware('permission:create-purchase|create-sale|edit-purchase|edit-sale', ['only' => ['purchase', 'store']]);
    $this->middleware('permission:edit-purchase|edit-sale|delete-purchase|delete-sale', ['only' => ['edit', 'update']]);
    $this->middleware('permission:delete-purchase|delete-sale', ['only' => ['destroy']]);
    $this->branch = explode("/", $request->route()->uri)[0] == 'branchs' ? $request->route()->parameters['id'] : false;
    $this->type = $request->route('type');
    $this->transcationRepo = $transcationRepo;
    $this->purchaseSaleRepo = $purchaseSaleRepo;
  }


  public function index(Request $request)
  {

    $branch = $this->branch;
    $_type = $this->type;
    $transcation_type = $_type == "sales" ? 'sale' : 'purchase';

    $perPage = 5;
    $page = request()->input('page', 1);
    $offset = ($page - 1) * $perPage;

    //total rows 
    $total = DB::select(" SELECT COUNT(*) as total FROM purchase_sales   WHERE type = ?
    AND (office_id = ? OR (office_id IS NULL AND ? = FALSE))", [$transcation_type, $branch, $branch])[0]->total;

    $purchasesDetails = DB::select("
    SELECT purchase_sales.*, 
           products.name as product_name,
           warehouses.name as warehouse_name,
           contacts.name as contact_name
    FROM purchase_sales
    LEFT JOIN products ON purchase_sales.product_id = products.id
    LEFT JOIN warehouses ON purchase_sales.warehouse_id = warehouses.id
    LEFT JOIN contacts ON purchase_sales.contact_id = contacts.id
    WHERE purchase_sales.type = ?
      AND (purchase_sales.office_id = ? OR (purchase_sales.office_id IS NULL AND ? = FALSE))
    LIMIT ?
    OFFSET ?
", [$transcation_type, $branch, $branch, $perPage, $offset]);

    $totalPages = ceil($total / $perPage);

    return view('administrator.sale_purchase.details', compact('branch', 'purchasesDetails', 'transcation_type', '_type', 'totalPages', 'page', 'perPage', 'total'));
  }


  public function create(Request $request)
  {


    $branch = $this->branch;
    $_type = $this->type;
    $this->purchaseSaleRepo->setContext($request);

    $warehouses = $this->purchaseSaleRepo->getWarehouses();

    $contact_type = $_type == 'sales' ? "customer" : "supplier";
    $contacts = Contact::where('type', $contact_type)->select('id', 'name')->get();
    $products = Product::all();

    return view('administrator.sale_purchase.create', compact('branch', '_type'), ['warehouses' => $warehouses, 'contacts' => $contacts, 'products' => $products]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(PurchaseSaleRequest $request)
  {


    $branch = $this->branch;
    $_type = $this->type;

    $datas = $request->validated();
    // dd($datas);
    //managing data 
    $rowCount = count($datas['contact_id']);
    $transcationData = [];

    for ($i = 0; $i < $rowCount; $i++) {
      $row = [];
      foreach ($datas as $key => $value) {
        if ($key == 'created_date') {
          $row[$key] = $value;
        } else {
          $row[$key] = $value[$i];
        }
      }
      $transcationData[] = $row;
    }


    // for storing sales information
    if ($_type == "sales") {
      DB::beginTransaction();
      try {
        foreach ($transcationData as $data) {
          $quantity = $this->transcationRepo->calculateAvailability($branch ? $branch : 0, $data['product_id'], $data['warehouse_id']);

          if ($quantity) {


            if ($data['quantity'] > $quantity) {

              return response()->json(['success' => false, 'message' => "Quantity exceed"]);
            } else {

              $this->purchaseSaleRepo->store($data);
            }
          } else {
            DB::rollback();
            return response()->json(['success' => false, 'message' => "Requested quantity not present in warehouse"]);
          }
        }
        DB::commit();
        return response()->json(['success' => true, 'message' => "Product has been sold"]);
      } catch (\Exception $e) {
        DB::rollback();
        // dd($e);
        return response()->json(['success' => false, 'message' => "Transcation failed"]);
      }
    }


    //for storing purchase information 
    if ($_type == "purchases") {
      DB::beginTransaction();
      foreach ($transcationData as $data) {

        try {

          $this->purchaseSaleRepo->store($data);
        } catch (\Exception $e) {

          DB::rollback();
          return response()->json(['success' => false, 'message' => "Failed to purchase"]);
        }
      }
      DB::commit();
      return response()->json(['success' => true, 'message' => "Product has been purchased"]);
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(Request $request)
  {

    $branch = $this->branch;
    $purchaseSaleId  = $request->route('typeId');
    $detail = $this->purchaseSaleRepo->find($purchaseSaleId);

    return view('administrator.sale_purchase.view', compact('detail', 'branch'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id, Request $request)
  {

    $branch = $this->branch;
    $_type = $this->type;
    $purchaseSaleId  = $request->route('typeId');

    $this->purchaseSaleRepo->setContext($request);
    $warehouses = $this->purchaseSaleRepo->getWarehouses();

    $contact_type = $_type == 'sales' ? "customer" : "supplier";
    $contacts = Contact::where('type', $contact_type)->select('id', 'name')->get();
    $products = Product::all();

    $purchaseSaleDetail = $this->purchaseSaleRepo->find($purchaseSaleId);


    return view('administrator.sale_purchase.create', compact('branch', '_type', 'purchaseSaleDetail'), ['warehouses' => $warehouses, 'contacts' => $contacts, 'products' => $products]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(PurchaseSaleRequest $request)
  {
    //
    $branch = $this->branch;
    $_type = $this->type;
    $id = $request->route('typeId');
    $datas = $request->validated();
    $data['product_id'] = $datas['product_id'][0];
    $data['contact_id'] = $datas['contact_id'][0];
    $data['quantity'] = $datas['quantity'][0];
    $data['total'] = $datas['total'][0];
    $data['warehouse_id'] = $datas['warehouse_id'][0];
    $data['created_date'] = $datas['created_date'];

    if ($_type == "purchases") {
      try {
        $this->purchaseSaleRepo->update($data, $id);
        return response()->json(['success' => true, 'message' => "Updated successfully"]);
      } catch (\Exception $e) {

        return response()->json(['success' => false, 'message' => $e]);
      }
    }


    if ($_type == "sales") {
      $quantity = $this->transcationRepo->calculateAvailability($branch ? $branch : 0, $data['product_id'], $data['warehouse_id']);


      try {
        if ($data['quantity'] <= $quantity) {
          $this->purchaseSaleRepo->update($data, $id);
          return response()->json(['success' => true, 'message' => "Updated successfully"]);
        }
        throw new Exception("Failed");
      } catch (Exception $e) {

        return response()->json(['success' => false, 'message' => "Failed to update"]);
      }
    }
  }
  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request)
  {
    $id = $request->route('typeId');
    $res = $this->purchaseSaleRepo->delete($id);
    if ($res) {
      return back()->withSuccess(' Deleted Successfully');
    } else {

      return back()->withError('Failed to delete');
    }
  }
}
