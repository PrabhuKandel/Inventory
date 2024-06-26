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
           contacts.name as contact_name
    FROM purchase_sales
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
    $products = DB::select("
    Select products.*,
    units.name as unit_name
    from products
    left join units on products.unit_id = units.id
    ");
    // dd($products);

    return view('administrator.sale_purchase.create', compact('branch', '_type'), ['warehouses' => $warehouses, 'contacts' => $contacts, 'products' => $products]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(PurchaseSaleRequest $request)
  {


    $datas = $request->validated();

    $res = $this->purchaseSaleRepo->store($datas);
    if ($res)
      return response()->json(['success' => true, 'message' => "Transcation success"]);
    else
      return response()->json(['success' => false, 'message' => "Transcation failed"]);
  }

  /**
   * Display the specified resource.
   */
  public function show(Request $request)
  {

    $branch = $this->branch;
    $purchaseSaleId  = $request->route('typeId');
    $details = $this->purchaseSaleRepo->find($purchaseSaleId);


    return view('administrator.sale_purchase.view', compact('details', 'branch'));
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
    $products = DB::select("
    Select products.*,
    units.name as unit_name
    from products
    left join units on products.unit_id = units.id
    ");

    $purchaseSaleDetail = $this->purchaseSaleRepo->find($purchaseSaleId);



    return view('administrator.sale_purchase.create', compact('branch', '_type', 'purchaseSaleDetail', 'purchaseSaleId', 'products'), ['warehouses' => $warehouses, 'contacts' => $contacts,]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(PurchaseSaleRequest $request)
  {
    //  
    $id = $request->route('typeId');
    $datas = $request->validated();

    $res  = $this->purchaseSaleRepo->update($datas, $id);
    if ($res)
      return response()->json(['success' => true, 'message' => "Details updated"]);
    else
      return response()->json(['success' => false, 'message' => "Failed to update"]);
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
