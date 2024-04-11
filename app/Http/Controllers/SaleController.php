<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\SaleRepositoryInterface;
use App\Interfaces\WarehouseRepositoryInterface;
use App\Models\Contact;
use App\Models\Product;
class SaleController extends Controller
{
    
    private SaleRepositoryInterface $saleRepo;
    private WarehouseRepositoryInterface $warehouseRepo;
    public function __construct(SaleRepositoryInterface $saleRepo,  WarehouseRepositoryInterface $warehouseRepo)

    {

       $this->saleRepo  = $saleRepo;
       $this->warehouseRepo = $warehouseRepo;

    }
    public function index(Request $request)
    {//branch id is needed
        $branch = explode("/",$request->route()->uri)[0]=='branchs'?$request->route()->parameters['id']:false;
        $salesDetails = $this->saleRepo->show($branch,$request);
        
        return view('administrator.sale.sale_details',compact('branch','salesDetails'));
    }
    
    public function sale(Request $request)
    {

     
        $branch = explode("/",$request->route()->uri)[0]=='branchs'?$request->route()->parameters['id']:false;
        if($branch)
        {

            $warehouses = $this->saleRepo->getById($branch);
        }
        else 
        {
            $warehouses = $warehouses = $this->warehouseRepo->getWarehousesOfBranch($branch);
        }
        $customers = Contact::where('type','customer')->select('id','name')->get();
        $products = Product::all();
        
        return view('administrator.sale.sale',compact('branch'),['warehouses'=>$warehouses,'customers'=>$customers,'products'=>$products]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { 
        $branch = explode("/",$request->route()->uri)[0]=='branchs'?$request->route()->parameters['id']:false;
        $request->validate([
            'contact'=>'required',
            'product'=>'required',
            'warehouse'=>'required',
            'date'=>'required',
            'quantity'=>'required',
            'total'=>'required'
          ]);

            $res=  $this->saleRepo->store($request, $branch);
             if($res){
                   return  back()->withSuccess("Product has been sold....");
               }else {
              dd($res);
               }
    
    }


     

//show sales details for specified branch    
    public function show(string $id, Request $request)
    {
             
             
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
