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

    $branchId = $request->input('branch_id');
    $branchId = $branchId ? $branchId : NULL;
    $transactionType = $request->input('transaction_type');




    $perPage = 5;
    $page = request()->input('page', 1);
    $offset = ((int)$page - 1) * $perPage;

    //common query
    $commonquery =  "  WHERE
    (
    CASE
    WHEN ? = 'all' THEN  TRUE
    WHEN ? IS NULL THEN transcations.office_id IS NULL
    ELSE transcations.office_id = ?
    END
     )
    AND 
    (
    CASE 
    WHEN ? = 'in' THEN transcations.type = 'in'
    WHEN ? = 'out' THEN transcations.type = 'out'
    WHEN ? = 'all' THEN TRUE
    END
    )
 ";
    //total rows
    $totalquery = "SELECT COUNT(*) as total FROM transcations " . $commonquery;

    $total = DB::select($totalquery, [$branchId, $branchId, $branchId, $transactionType, $transactionType, $transactionType])[0]->total;



    $reportquery = "SELECT transcations.*,
    warehouses.name as warehouse_name,
    contacts.name as contact_name,
    products.name as product_name,
    users.name as user_name
    FROM transcations
    LEFT JOIN products ON transcations.product_id = products.id
    LEFT JOIN warehouses ON transcations.warehouse_id = warehouses.id
    LEFT JOIN contacts ON transcations.contact_id = contacts.id
    LEFT JOIN users ON transcations.user_id = users.id" . $commonquery . " LIMIT ?
    OFFSET ?";

    $reports = DB::select($reportquery, [$branchId, $branchId, $branchId, $transactionType, $transactionType, $transactionType, $perPage, $offset]);


    $totalPages = ceil($total / $perPage);
    return response()->json(['reports' => $reports, 'perPage' => $perPage, 'page' => $page, 'total' => $total, 'totalPages' => $totalPages, 'branchId' => $branchId]);




    // $total = DB::select(" SELECT COUNT(*) as total FROM transcations 
    //   WHERE
    // (
    // CASE
    // WHEN ? = 'all' THEN  TRUE
    // WHEN ? IS NULL THEN transcations.office_id IS NULL
    // ELSE transcations.office_id = ?
    // END
    //  )
    // AND 
    // (
    // CASE 
    // WHEN ? = 'in' THEN transcations.type = 'in'
    // WHEN ? = 'out' THEN transcations.type = 'out'
    // WHEN ? = 'all' THEN TRUE
    // END
    // )

    // ", [$branchId, $branchId, $branchId, $transactionType, $transactionType, $transactionType])[0]->total;



    // $reports = DB::select("
    // SELECT transcations.*,
    // warehouses.name as warehouse_name,
    // contacts.name as contact_name,
    // products.name as product_name,
    // users.name as user_name
    // FROM transcations
    // LEFT JOIN products ON transcations.product_id = products.id
    // LEFT JOIN warehouses ON transcations.warehouse_id = warehouses.id
    // LEFT JOIN contacts ON transcations.contact_id = contacts.id
    // LEFT JOIN users ON transcations.user_id = users.id
    // WHERE
    // (
    // CASE
    // WHEN ? = 'all' THEN  TRUE
    // WHEN ? IS NULL THEN transcations.office_id IS NULL
    // ELSE transcations.office_id = ?
    // END
    //  )
    // AND 
    // (
    // CASE 
    // WHEN ? = 'in' THEN transcations.type = 'in'
    // WHEN ? = 'out' THEN transcations.type = 'out'
    // WHEN ? = 'all' THEN TRUE
    // END
    // )
    // LIMIT ?
    // OFFSET ?
    // ", [$branchId, $branchId, $branchId, $transactionType, $transactionType, $transactionType, $perPage, $offset]);

  }
}
