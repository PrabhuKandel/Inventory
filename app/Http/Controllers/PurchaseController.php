<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\PurchaseRepositoryInterface;
use App\Models\Contact;
use App\Models\Product;
use App\Interfaces\WarehouseRepositoryInterface;
class PurchaseController extends Controller
{
    
    private PurchaseRepositoryInterface $purchaseRepo;
    private WarehouseRepositoryInterface $warehouseRepo;
    public function __construct(PurchaseRepositoryInterface $purchaseRepo,  WarehouseRepositoryInterface $warehouseRepo)

    {

       $this->purchaseRepo  = $purchaseRepo;
       $this->warehouseRepo = $warehouseRepo;

    }
    public function index(Request $request)
    {//branch id is needed
        $branch = explode("/",$request->route()->uri)[0]=='branchs'?$request->route()->parameters['id']:false;
        $purchasesDetails = $this->purchaseRepo->show($branch,$request);
        return view('administrator.purchase.purchase_details',compact('branch','purchasesDetails'));
    }
    public function purchase(Request $request)
    {
        
        $branch = explode("/",$request->route()->uri)[0]=='branchs'?$request->route()->parameters['id']:false;
        if($branch)
        {

            $warehouses = $this->purchaseRepo->getById($branch);
        }
        else 
        {
            $warehouses = $warehouses = $this->warehouseRepo->getWarehousesOfBranch($branch);
        }
        $customers = Contact::where('type','supplier')->select('id','name')->get();
        $products = Product::all();
        
        return view('administrator.purchase.purchase',compact('branch'),['warehouses'=>$warehouses,'customers'=>$customers,'products'=>$products]);
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

            $res=  $this->purchaseRepo->store($request, $branch);
             if($res){
                   return  back()->withSuccess("Product has been purchased....");
               }else {
                dd($res);
               }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
              
        // $branch = explode("/",$request->route()->uri)[0]=='branchs'?$request->route()->parameters['id']:false;
        // return view('administrator.purchase.purchase_details',compact('branch'));
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
