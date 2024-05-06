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
    SELECT transcations.*,
    products.name as product_name,
    warehouses.name as warehouse_name,
    contacts.name as contact_name
    FROM transcations
    LEFT JOIN products ON transcations.product_id = products.id
    LEFT JOIN warehouses ON transcations.warehouse_id = warehouses.id
    LEFT JOIN contacts ON transcations.contact_id = contacts.id
    WHERE  purchaseSale_id=$id");

    return $details;
  }

  public function store(array $datas)

  {

    // dd($datas);

    try {
      $this->setContext(request());
      $branch = $this->branch;
      $type = $this->type;

      //matching requested quantity with availability


      //update this all
      $purchaseSale = new PurchaseSale([
        'type' => $type == 'sales' ? 'sale' : "purchase",
        'contact_id' => $datas['contact_id'],
        'office_id' => $branch ? $branch : null,
      ]);

      $purchaseSale->save();


      for ($i = 0; $i < count($datas['product_id']); $i++) {

        $transcation = new Transcation([
          'type' => $type == "sales" ? "out" : "in",
          'created_date' => $datas['created_date'],
          'contact_id' => $datas['contact_id'],
          'office_id' =>  $branch ? $branch : null,
          'user_id' => Auth::user()->id,
          'quantity' => $datas['quantity'][$i],
          'amount' => $datas['total'][$i],
          'product_id' => $datas['product_id'][$i],
          'warehouse_id' => $datas['warehouse_id'][$i],
          'purchaseSale_id' => $purchaseSale->id,

        ]);
        $transcation->save();
      }
      return true;
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

  public function update($datas, $id)
  {


    // DB::transaction();
    try {
      $this->setContext(request());
      $branch = $this->branch;
      $type = $this->type;


      // Update PurchaseSale record
      PurchaseSale::where('id', $id)->update([

        'type' => $type == 'sales' ? 'sale' : "purchase",
        'contact_id' => $datas['contact_id'],
        'office_id' => $branch ? $branch : null,
      ]);



      for ($i = 0; $i < count($datas['product_id']); $i++) {

        Transcation::where('purchaseSale_id', $id)->update([
          'type' => $type == "sales" ? "out" : "in",
          'created_date' => $datas['created_date'],
          'contact_id' => $datas['contact_id'],
          'office_id' =>  $branch ? $branch : null,
          'user_id' => Auth::user()->id,
          'quantity' => $datas['quantity'][$i],
          'amount' => $datas['total'][$i],
          'product_id' => $datas['product_id'][$i],
          'warehouse_id' => $datas['warehouse_id'][$i],

        ]);
        // Update Transcation record
      }
      return true;
    } catch (\Exception $e) {
      throw $e;
    }
  }
}
