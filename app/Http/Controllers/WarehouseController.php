<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\Office;
use App\Repositories\CommonRepository;
use App\Http\Middleware\BranchAccessMiddleware;
use Illuminate\Support\Facades\DB;




class WarehouseController extends Controller
{

    public  $branch_id;
    private  $warehouseRepo;
    private $branchRepo;
    public $branch;
    public function __construct(Request $request)

    {


        $this->warehouseRepo  = new  CommonRepository(new Warehouse());
        $this->branchRepo = new CommonRepository(new Office());
        $this->middleware(BranchAccessMiddleware::class);
        $this->middleware('permission:view-warehouse|create-warehouse|edit-warehouse|delete-warehouse')->only('index');
        $this->middleware('permission:create-warehouse|edit-warehouse', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-warehouse|delete-warehouse', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-warehouse', ['only' => ['destroy']]);
        $this->branch = explode("/", $request->route()->uri)[0] == 'branchs' && isset($request->route()->parameters['id']) ? $request->route()->parameters['id'] : false;
    }
    public function index(Request $request)
    {
        $branch = $this->branch;
        $warehouses =   $branch ? Warehouse::where('office_id', $branch)->paginate(5) : Warehouse::whereNull('office_id')->paginate(5);

        return  view('administrator.warehouse.warehouse_details', compact('warehouses', 'branch'));
    }

    public function show(Request $request)

    {
        $branch = $this->branch;
        $warehouseId = $request->route('warehouse');
        $warehouse = $this->warehouseRepo->find($warehouseId);
        //finding products in that warehouse
        return view('administrator.warehouse.view_warehouse', compact('warehouse', 'branch'));
    }
    /**
     * Show the form for creating a warehouses.
     */
    public function create(Request  $request)
    {


        // $branch = explode("/",$request->route()->uri)[0]=='branchs' && isset($request->route()->parameters['id'])?$request->route()->parameters['id']:false;
        $branch = $this->branch;
        return view('administrator.warehouse.create_warehouse', compact('branch'));
    }


    /**
     * Store a newly created warehouses in storage.
     */
    public function store(Request $request)
    {


        $data =   $request->validate([
            'name' => 'required|unique:warehouses',
            'address' => 'required',
            'created_date' => 'required',
        ]);
        $data['office_id'] = $this->branch ? $this->branch : null;
        $response = $this->warehouseRepo->store($data);
        if ($response) {
            return back()->withSuccess('Warehouse created...');
        }
    }

    /**
     * Display the warehouse details.
     */

    public function edit(Request $request)
    {
        $branch = $this->branch;
        $warehouse_id  =  isset($request->route()->parameters['warehouse']) ? $request->route()->parameters['warehouse'] : false;
        $warehouse = $this->warehouseRepo->find($warehouse_id);
        return view('administrator.warehouse.create_warehouse', ['warehouse' => $warehouse], compact('branch'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)

    {

        $warehouse = $request->route('warehouse');
        $data =  $request->validate([
            'name' => 'required|unique:warehouses,name,' . $warehouse,
            'address' => 'required',

        ]);

        $response = $this->warehouseRepo->update($data, $warehouse);
        if ($response) {
            return back()->withSuccess('Warehouse Updated Successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //id means branch id
        $warehouse = $request->route('warehouse');
        $response = $this->warehouseRepo->delete($warehouse);
        if ($response) {
            return back()->withSuccess('Warehouse deleted');
        } else {

            return back()->withSuccess('Sorry cant delete, Product present in warehouse');
        }
    }

    public function warehousesOfBranchs(Request $request)
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
        $filterOffice = $head ? " WHERE (" . ($ids_str ? "warehouses.office_id IN ($ids_str) OR" : '') . " warehouses.office_id IS NULL)" : " WHERE warehouses.office_id IN ($ids_str)";

        $warehouses = DB::select("
        SELECT * FROM warehouses" . $filterOffice);

        return response()->json(['warehouses' => $warehouses, 'branchId' => $branchId, 'ids' => $ids_str, 'head' => $head]);
    }
}
