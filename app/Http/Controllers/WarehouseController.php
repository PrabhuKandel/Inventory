<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\WarehouseRepositoryInterface;
use App\Interfaces\BranchRepositoryInterface;


class WarehouseController extends Controller
{
   
    public  $branch_id;
    private WarehouseRepositoryInterface $warehouseRepo;
    private BranchRepositoryInterface $branchRepo;
     public function __construct(WarehouseRepositoryInterface $warehouseRepo, BranchRepositoryInterface $branchRepo,Request $request)

     {
        
        $this->warehouseRepo  = $warehouseRepo;
        $this->branchRepo = $branchRepo;

        $this->branch = explode("/",$request->route()->uri)[0]=='branchs' && isset($request->route()->parameters['id'])?$request->route()->parameters['id']:false;

      
     }
    public function index(Request $request)
    {

        
       
        $branch = explode("/",$request->route()->uri)[0]=='branchs' && isset($request->route()->parameters['id'])?$request->route()->parameters['id']:false;
      
 
        return  view('administrator.warehouse.warehouse_details',compact('warehouses','branch'));
        // //get warehouses of branch
 
        // $branch = explode("/",$request->route()->uri)[0]=='branchs' && isset($request->route()->parameters['id'])?$request->route()->parameters['id']:false;
        // $warehouses = $this->warehouseRepo->getWarehousesOfBranch($id);
        
        // return  view('administrator.warehouse.warehouse_details', ['branchId'=>$branchId],compact('warehouses','branch'));


        // return  view('administrator.warehouse.warehouse_details');
    }

    /**
     * Show the form for creating a warehouses.
     */
    public function create(Request  $request)
    {
        // $branch = explode("/",$request->route()->uri)[0]=='branchs' && isset($request->route()->parameters['id'])?$request->route()->parameters['id']:false;
        // if($branch)
        // {}
          
            $branch = explode("/",$request->route()->uri)[0]=='branchs' && isset($request->route()->parameters['id'])?$request->route()->parameters['id']:false;

            return view('administrator.warehouse.create_warehouse',compact('branch'));

        
        // else{
        //     //since branch is not set so it is for headquarter
         
        //     return view('administrator.warehouse.create_warehouse');

        
        
    }
    public function createWithId($id, Request $request)
    {
        $branch = explode("/",$request->route()->uri)[0]=='branchs' && isset($request->route()->parameters['id'])?$request->route()->parameters['id']:false;
     $branchIn = $this->branchRepo->getById($id);
     return view('administrator.warehouse.create_warehouse',['branchIn'=>$branchIn],compact('branch'));


    }
    public function getWarehousesOfBranch($id,Request $request)
    {
        //not used
       
        // $branchId = $id;
        // $branch = explode("/",$request->route()->uri)[0]=='branchs' && isset($request->route()->parameters['id'])?$request->route()->parameters['id']:false;
        // $warehouses = $this->warehouseRepo->getWarehousesOfBranch($id);
        
        // return  view('administrator.warehouse.warehouse_details', ['branchId'=>$branchId],compact('warehouses','branch'));
    }

    /**
     * Store a newly created warehouses in storage.
     */
    public function store(Request $request)
    {
         $response = $this->warehouseRepo->store($request);
         if($response)
         {
            return back()->withSuccess('Warehouse created...');
         }
    }

    /**
     * Display the warehouse details.
     */
    public function show(string $id)
    {
        //here id is not of warehouse it is of branch like warehouses/1 means warehouses of branch 1
        
        return view('administrator.warehouse.warehouse_details');
        
  
    }
     public function edit( Request $request)
    {
        $branch = $this->branch;
      $warehouse_id  =  isset($request->route()->parameters['warehouse'])?$request->route()->parameters['warehouse']:false;
      
        $warehouse = $this->warehouseRepo->getById($warehouse_id);

        return view('administrator.warehouse.edit_warehouse',['warehouse'=>$warehouse],compact('branch'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    // public function edit( string $branch_id = null, string $warehouse_id, Request $request)
    // {
    //             $branch = explode("/",$request->route()->uri)[0]=='branchs' && isset($request->route()->parameters['id'])?$request->route()->parameters['id']:false;
        
    //     $warehouse = $this->warehouseRepo->getById($warehouse_id);

    //     return view('administrator.warehouse.edit_warehouse',['warehouse'=>$warehouse],compact('branch'));
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    
        $response = $this->warehouseRepo->update($request ,$id);
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
