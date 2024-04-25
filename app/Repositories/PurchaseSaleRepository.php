<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\PurchaseSale;
use App\Repositories\CommonRepository;
use Illuminate\Support\Facades\DB;

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


  public function index()
  {
    $this->setContext(request()); // Set context for each function call
    $branch = $this->branch;
    $type = $this->type;
    $transcation_type = $type == "sales" ? 'sale' : 'purchase';

    $perPage = 2;
    $page = 1;
    $offset = 2;

    //total rows 
    $total = DB::select(" SELECT COUNT(*) as total FROM purchase_sales")[0]->total;

    $purchasesDetails = DB::select(
      "  
    SELECT * FROM purchase_sales
    WHERE type = ?
    AND (office_id = ? OR (office_id IS NULL AND ? = FALSE))
    LIMIT ?
    OFFSET ?
    ",
      [$transcation_type, $branch, $branch, $perPage, $offset]
    );

    $totalPages = ceil($total / $perPage);

    return [$purchasesDetails, $totalPages, $page];
    dd($purchasesDetails);

    /* $purchasesDetails = PurchaseSale::where('type', $transcation_type)->when(
      $branch,
      function ($query) use ($branch) {

        return $query->where('office_id', $branch);
      },
      function ($query) {

        return $query->WhereNull('office_id');
      }
    )->paginate(5);

    return $purchasesDetails;*/
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



  public function delete($id)
  {
    try {
      PurchaseSale::where('id', $id)->delete();
      return true;
    } catch (\Exception $e) {
      return false;
    }
  }
}
