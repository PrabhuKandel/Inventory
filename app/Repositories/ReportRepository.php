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

    $branchId = $request->input('branch_id', false);
    $branchId = $branchId ? $branchId : false;
    $transactionType = $request->input('transaction_type', 'in');



    $perPage = 10;
    $page = request()->input('page', 1);
    $offset = ($page - 1) * $perPage;

    //total rows 
    $total = DB::select(" SELECT COUNT(*) as total FROM transcations   WHERE type = ?
    AND (office_id = ? OR (office_id IS NULL AND ? = FALSE))", [$transactionType, $branchId, $branchId])[0]->total;


    $reports = DB::select("
    SELECT transcations.*,
    warehouses.name as warehouse_name,
    contacts.name as contact_name,
    products.name as product_name,
    users.name as user_name
    FROM transcations
    LEFT JOIN products ON transcations.product_id = products.id
    LEFT JOIN warehouses ON transcations.warehouse_id = warehouses.id
    LEFT JOIN contacts ON transcations.contact_id = contacts.id
    LEFT JOIN users ON transcations.user_id = users.id
    WHERE (transcations.type = ?)
    AND (transcations.office_id = ? OR (transcations.office_id IS NULL AND ? = FALSE))
    LIMIT ?
    OFFSET ?
    ", [$transactionType, $branchId, $branchId, $perPage, $offset]);

    $totalPages = ceil($total / $perPage);
    return response()->json(['reports' => $reports, 'perPage' => $perPage, 'page' => $page, 'total' => $total, 'totalPages' => $totalPages]);
  }
}
