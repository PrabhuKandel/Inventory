<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\PurchaseSale;
use App\Models\Transcation;
use App\Repositories\WarehouseRepository;
class PurchaseController extends Controller
{
    private  $warehouseRepo;
    public function __construct(  WarehouseRepository $warehouseRepo)

    {
       $this->warehouseRepo = $warehouseRepo;

    }
    public function index(Request $request)
    {//branch id is needed
        $branch = explode("/",$request->route()->uri)[0]=='branchs'?$request->route()->parameters['id']:false;
       
        $purchasesDetails = $branch? PurchaseSale::where('office_id',$branch)->get():PurchaseSale::whereNull('office_id')->get();  
        return view('administrator.purchase.purchase_details',compact('branch','purchasesDetails'));
    }


    public function purchase(Request $request)
    {
        
        $branch = explode("/",$request->route()->uri)[0]=='branchs'?$request->route()->parameters['id']:false;
        $warehouses =$branch? Warehouse::where('office_id',$branch)->get():Warehouse::whereNull('office_id')->get();
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
            'contact_id'=>'required',
            'product_id'=>'required',
            'warehouse_id'=>'required',
            'created_date'=>'required',
            'quantity'=>'required',
            'total'=>'required'
          ]);

          try{
            // dd($request->toArray());
            $purchaseSale = new PurchaseSale([
      
              'warehouse_id'=>$request->warehouse_id,
                'product_id'=>$request->product_id,
                'quantiy'=>$request->quantity,
                'type'=>'purchase',
                'contact_id'=>$request->contact_id,
                'office_id'=>$branch?$branch:null,
            
            
            ]);
            $purchaseSale->save();
      
          $transcation = new  Transcation([
            'type'=>"in",
            'quantity'=>$request->quantity,
            'amount'=>$request->total,
            'warehouse_id'=>$request->warehouse_id,
            'contact_id'=>$request->contact_id,//not necessary 
            'product_id'=>$request->product_id,
            'user_id'=>1,
            'created_date'=>$request->created_date,
            'office_id'=>$branch?$branch:null,
            'purchaseSale_id' =>$purchaseSale->id,
          ]);
      
          // dd($transcation);
          $transcation->save();
          return  back()->withSuccess("Product has been purchased....");
          }
      catch(\Exception $e){
       
        return  back()->withSuccess("Fail to purchase");
        }
    }

    /**
     * Display the specified resource.
     */
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
        //deleting purchase info from purchase and sale table
        try{
            PurchaseSale::where('id',$id)->delete();
            return back()->withSuccess('Purchase details Deleted Successfully'); 
       }catch(Exception $e){
        return back()->withError('Failed to delete'); 
       }
    

    }
}
