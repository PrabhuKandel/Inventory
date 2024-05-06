<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Repositories\CommonRepository;
use Illuminate\Support\Facades\DB;
use App\Models\Transcation;

class ReportRepository extends  CommonRepository
{
  public function __construct(Transcation $report)
  {
    parent::__construct($report);
  }

  public function index(Request $request)
  {


    $branchId =  $request->input('branch_id');
    $branchId = is_array($branchId) ? $branchId : [$branchId];

    $Ids = [];
    $ids_str = "";
    foreach ($branchId as $key => $value) {
      //checking if headoffice is selected 
      if (!is_null($value)) {
        $ids_str .= intval($value);
        $ids_str .= $key < count($branchId) - 1 ? "," : '';
        $Ids[] = intval($value);
      }
    };

    $head = count($Ids) < count($branchId);

    $transactionType = $request->input('transaction_type');

    $perPage = 5;
    $page = request()->input('page', 1);
    $offset = ((int)$page - 1) * $perPage;

    //checking if headquarter is present and if headquarter is only present (ie. $ids_str is null) then skip some part of query

    $commonquerysub = $head ? " WHERE (" . ($ids_str ? "transcations.office_id IN ($ids_str) OR" : '') . " transcations.office_id IS NULL)" : " WHERE transcations.office_id IN ($ids_str)";

    $commonquerymain =   $commonquerysub . "
    AND 
    (
    CASE 
    WHEN ? = 'in' THEN transcations.type = 'in'
    WHEN ? = 'out' THEN transcations.type = 'out'
    WHEN ? = 'all' THEN TRUE
    END
    )";

    // total rows
    $totalquery = "SELECT COUNT(*) as total FROM transcations " . $commonquerymain;

    $total = DB::select($totalquery, [$transactionType, $transactionType, $transactionType])[0]->total;

    $reportquery = "SELECT transcations.*,
    warehouses.name as warehouse_name,
    contacts.name as contact_name,
    products.name as product_name,
    users.name as user_name
    FROM transcations
    LEFT JOIN products ON transcations.product_id = products.id
    LEFT JOIN warehouses ON transcations.warehouse_id = warehouses.id
    LEFT JOIN contacts ON transcations.contact_id = contacts.id
    LEFT JOIN users ON transcations.user_id = users.id" . $commonquerymain . " LIMIT ?
    OFFSET ?";
    // dd($reportquery);
    $reports = DB::select($reportquery, [$transactionType, $transactionType, $transactionType, $perPage, $offset]);


    $totalPages = ceil($total / $perPage);
    return response()->json(['reports' => $reports, 'perPage' => $perPage, 'page' => $page, 'total' => $total, 'totalPages' => $totalPages, 'transactionType' => $transactionType]);
  }


  public function productAvailability(Request $request)
  {

    $branchId =  $request->input('branch_id');
    $branchId = is_array($branchId) ? $branchId : [$branchId];

    $Ids = [];
    $ids_str = "";
    foreach ($branchId as $key => $value) {
      //checking if headoffice is selected 
      if (!is_null($value)) {
        $ids_str .= intval($value);
        $ids_str .= $key < count($branchId) - 1 ? "," : '';
        $Ids[] = intval($value);
      }
    };

    $head = count($Ids) < count($branchId);

    //checking if headquarter is present and if headquarter is only present (ie. $ids_str is null) then skip some part of query
    $filterOffice = $head ? " WHERE (" . ($ids_str ? "transcations.office_id IN ($ids_str) OR" : '') . " transcations.office_id IS NULL)" : " WHERE transcations.office_id IN ($ids_str)";

    $reports = DB::select("
    SELECT  
    transcations.product_id,
    products.name AS product_name,
    SUM(CASE WHEN transcations.type = 'in' THEN transcations.quantity ELSE -transcations.quantity END) AS total_quantity
    FROM transcations
    LEFT JOIN  products ON transcations.product_id= products.id"
      . $filterOffice .
      "GROUP BY
       transcations.product_id, products.name");

    // dd($reports);
    return response()->json(['reports' => $reports]);
  }

  public function productAvailabilityByWarehouse(Request $request)
  {


    $branchId = (int)  $request->input('branch_id');

    $warehouseId =  $request->input('warehouse_id');
    $productId =  $request->input('product_id');
    $warehouseId = is_array($warehouseId) ? $warehouseId : [$warehouseId];
    $productId = is_array($productId) ? $productId : [$productId];


    $productIdsStr = implode(',', $productId);
    $warehouseIdsStr = implode(',', $warehouseId);

    // dd($branchId);

    // dd($productIdsStr, $warehouseIdsStr);
    $filterProduct = $productIdsStr ? " AND transcations.product_id IN ($productIdsStr)" : "";
    $filterWarehouse = $warehouseIdsStr ? " AND transcations.warehouse_id IN ($warehouseIdsStr) " : "";
    $filterOffice = $branchId ? "AND transcations.office_id = ($branchId)" : "";
    // dd($filterOffice);


    $reports = DB::select("
     SELECT  
     transcations.product_id,
     products.name AS product_name,
     SUM(CASE WHEN transcations.type = 'in' THEN transcations.quantity ELSE -transcations.quantity END) AS total_quantity
     FROM transcations
     LEFT JOIN  products ON transcations.product_id= products.id
     LEFT JOIN  warehouses ON transcations.warehouse_id= warehouses.id
     WHERE transcations.product_id IS NOT NULL
     " . $filterOffice
      . $filterWarehouse .
      $filterProduct .

      "  GROUP BY
        transcations.product_id ,products.name ");

    return response()->json(['reports' => $reports]);
  }
}
