<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\Office;
use App\Repositories\CommonRepository;
use App\Http\Middleware\BranchAccessMiddleware; 
use Illuminate\Support\Facades\Auth;




class WarehouseController extends Controller
{
   
    public  $branch_id;
    private  $warehouseRepo;
    private $branchRepo;
     public function __construct(Request $request)

     {
        
        
        $this->warehouseRepo  = new  CommonRepository( new Warehouse());
        $this->branchRepo = new CommonRepository(new Office());
        $this->middleware(BranchAccessMiddleware::class);
        $this->middleware('permission:view-warehouse|create-warehouse|edit-warehouse|delete-warehouse')->only('index');
        $this->middleware('permission:create-warehouse|edit-warehouse', ['only' => ['create','store']]);
        $this->middleware('permission:edit-warehouse|delete-warehouse', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-warehouse', ['only' => ['destroy']]);
        $this->branch = explode("/",$request->route()->uri)[0]=='branchs' && isset($request->route()->parameters['id'])?$request->route()->parameters['id']:false;

      
     }
    public function index(Request $request)
    {
        $branch = $this->branch;
              $warehouses =   $branch ? Warehouse::where('office_id', $branch)->get() : Warehouse::whereNull('office_id')->get();
 
        return  view('administrator.warehouse.warehouse_details',compact('warehouses','branch'));

    }

    public function show(string $id)

    {
        $warehouse = $this->warehouseRepo->find($id);
        //finding products in that warehouse
        return view('administrator.warehouse.view_warehouse',compact('warehouse'));
    }
    /**
     * Show the form for creating a warehouses.
     */
    public function create(Request  $request)
    {
        
          
            // $branch = explode("/",$request->route()->uri)[0]=='branchs' && isset($request->route()->parameters['id'])?$request->route()->parameters['id']:false;
            $branch = $this->branch;
            return view('administrator.warehouse.create_warehouse',compact('branch'));

        
        
    }
   

    /**
     * Store a newly created warehouses in storage.
     */
    public function store(Request $request)
    {
     
        
        $data =   $request->validate([
        'name'=>'required|unique:warehouses',
        'address'=>'required',
        'created_date'=>'required',
      ]);
      $data['office_id'] = $this->branch?$this->branch:null;
         $response = $this->warehouseRepo->store($data);
         if($response)
         {
            return back()->withSuccess('Warehouse created...');
         }
    }

    /**
     * Display the warehouse details.
     */

     public function edit( Request $request)
    {
        $branch = $this->branch;
      $warehouse_id  =  isset($request->route()->parameters['warehouse'])?$request->route()->parameters['warehouse']:false;
        $warehouse = $this->warehouseRepo->find($warehouse_id);
        return view('administrator.warehouse.create_warehouse',['warehouse'=>$warehouse],compact('branch'));
    }
   

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request)

    {
    
      $warehouse = $request->route('warehouse');
        $data =  $request->validate([
            'name'=>'required|unique:warehouses,name,' . $warehouse ,
            'address'=>'required',
           
          ]);
    
        $response = $this->warehouseRepo->update($data ,$warehouse);
        if($response){
            return back()->withSuccess('Warehouse Updated Successfully!');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(  Request $request)
    {
        //id means branch id
        $warehouse= $request->route('warehouse');
        $response = $this->warehouseRepo->delete($warehouse);
        if($response){
            return back()->withSuccess('Warehouse deleted');
        }
        else {

            return back()->withSuccess('Sorry cant delete, Product present in warehouse');
        }
    }
}
