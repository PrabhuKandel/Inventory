<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\PurchaseSale;
use App\Models\Transcation;
use App\Repositories\CommonRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PurchaseSaleRepository extends CommonRepository
{

  private $branch;
  private $type;
  public function __construct(PurchaseSale $purchaseSale)
  {
    parent::__construct($purchaseSale);
  }
  public function setContext(Request $request)
  {

    $this->branch = explode("/", $request->route()->uri)[0] == 'branchs' ? $request->route()->parameters['id'] : false;
    $this->type = $request->route('type');
  }


  public function find($id)
  {
    $details =  DB::select("
    SELECT purchase_sales.*, 
    products.name as product_name,
    warehouses.name as warehouse_name,
    contacts.name as contact_name
    FROM purchase_sales
    LEFT JOIN  products ON products.id=purchase_sales.product_id
    LEFT JOIN  warehouses ON warehouses.id=purchase_sales.warehouse_id
    LEFT JOIN  contacts ON contacts.id=purchase_sales.contact_id
    WHERE  purchase_sales.id=$id");

    return $details[0];
  }

  public function store(array $data)

  {

    try {
      $this->setContext(request());
      $branch = $this->branch;
      $type = $this->type;

      $purchaseSale = new PurchaseSale([
        'warehouse_id' => $data['warehouse_id'],
        'product_id' => $data['product_id'],
        'quantiy' => $data['quantity'],
        'type' => $type == 'sales' ? 'sale' : "purchase",
        'contact_id' => $data['contact_id'],
        'office_id' => $branch ? $branch : null,
      ]);

      $purchaseSale->save();

      $transcation = new  Transcation([
        'type' => $type == "sales" ? "out" : "in",
        'quantity' => $data['quantity'],
        'amount' => $data['total'],
        'warehouse_id' => $data['warehouse_id'],
        'contact_id' => $data['contact_id'],
        'product_id' => $data['product_id'],
        'user_id' => Auth::user()->id,
        'created_date' => $data['created_date'],
        'office_id' => $branch ? $branch : null,
        'purchaseSale_id' => $purchaseSale->id,
      ]);

      $transcation->save();
    } catch (\Exception $e) {
      throw $e;
    }
  }

  public function getWarehouses()

  {
    $this->setContext(request()); // Set context for each function call
    $branch = $this->branch;

    $warehouses = Warehouse::when($branch, function ($query) use ($branch) {
      return   $query->where("office_id", $branch);
    }, function ($query) {
      return $query->WhereNull('office_id');
    })->get();

    return $warehouses;
  }

  public function update($data, $id)
  {


    try {
      $this->setContext(request());
      $branch = $this->branch;
      $type = $this->type;


      // Update PurchaseSale record
      PurchaseSale::where('id', $id)->update([
        'warehouse_id' => $data['warehouse_id'],
        'product_id' => $data['product_id'],
        'quantiy' => $data['quantity'],
        'contact_id' => $data['contact_id'],
        'office_id' => $branch ? $branch : null,
      ]);

      // Update Transcation record
      Transcation::where('purchaseSale_id', $id)->update([

        'quantity' => $data['quantity'],
        'amount' => $data['total'],
        'warehouse_id' => $data['warehouse_id'],
        'contact_id' => $data['contact_id'],
        'product_id' => $data['product_id'],
        'user_id' => Auth::user()->id,
        'created_date' => $data['created_date'],
        'office_id' => $branch ? $branch : null,
      ]);
    } catch (\Exception $e) {
      throw $e;
    }
  }
}
