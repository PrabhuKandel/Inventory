<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Repositories\WarehouseRepository;
use App\Repositories\BranchRepository;
use App\Http\Middleware\BranchAccessMiddleware; 



class WarehouseController extends Controller
{
   
    public  $branch_id;
    private  $warehouseRepo;
    private $branchRepo;
     public function __construct(WarehouseRepository $warehouseRepo, BranchRepository $branchRepo,Request $request)

     {
        
        $this->warehouseRepo  = $warehouseRepo;
        $this->branchRepo = $branchRepo;
        $this->middleware(BranchAccessMiddleware::class);
        $this->branch = explode("/",$request->route()->uri)[0]=='branchs' && isset($request->route()->parameters['id'])?$request->route()->parameters['id']:false;

      
     }
    public function index(Request $request)
    {
        $branch = $this->branch;
              $warehouses =   $branch ? Warehouse::where('office_id', $branch)->get() : Warehouse::whereNull('office_id')->get();
 
        return  view('administrator.warehouse.warehouse_details',compact('warehouses','branch'));

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
        return view('administrator.warehouse.edit_warehouse',['warehouse'=>$warehouse],compact('branch'));
    }
   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data =  $request->validate([
            'name'=>'required|unique:warehouses,name,' . $id ,
            'address'=>'required',
           
          ]);
    
        $response = $this->warehouseRepo->update($data ,$id);
        if($response){
            return back()->withSuccess('Warehouse Updated Successfully!');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $response = $this->warehouseRepo->delete($id);
        if($response){
            return back()->withSuccess('Warehouse deleted');
        }
        else {

            return back()->withSuccess('Sorry cant delete, Product present in warehouse');
        }
    }
}
