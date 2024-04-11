<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\WarehouseRepositoryInterface;
use App\Interfaces\BranchRepositoryInterface;


class WarehouseController extends Controller
{
    private WarehouseRepositoryInterface $warehouseRepo;
    private BranchRepositoryInterface $branchRepo;
     public function __construct(WarehouseRepositoryInterface $warehouseRepo, BranchRepositoryInterface $branchRepo)

     {

        $this->warehouseRepo  = $warehouseRepo;
        $this->branchRepo = $branchRepo;
     }
    public function index(Request $request)
    {

        
       
        $branch = explode("/",$request->route()->uri)[0]=='branchs' && isset($request->route()->parameters['id'])?$request->route()->parameters['id']:false;
        if ($branch) {
                        $warehouses = $this->warehouseRepo->getWarehousesOfBranch($branch);
        }else{
           
            $warehouses = $warehouses = $this->warehouseRepo->getWarehousesOfBranch($branch);
        }

        
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $warehouse = $this->warehouseRepo->getById($id);

        return view('administrator.warehouse.edit_warehouse',['warehouse'=>$warehouse]);
    }

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
        dd("requested to delete");
    }
}
