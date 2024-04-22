<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\PurchaseSale;
use App\Models\Transcation;
use App\Repositories\WarehouseRepository;
use App\Http\Middleware\BranchAccessMiddleware; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class PurchaseController extends Controller
{
    private  $warehouseRepo;
    public function __construct(  WarehouseRepository $warehouseRepo)

    {
        $this->middleware(BranchAccessMiddleware::class);
        $this->middleware('permission:view-purchase|create-purchase|edit-purchase|delete-purchase')->only('index');
        $this->middleware('permission:create-purchase|edit-purchase', ['only' => ['create','store']]);
        $this->middleware('permission:edit-purchase|delete-purchase', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-purchase', ['only' => ['destroy']]);
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
        return view('administrator.purchase.demo',compact('branch'),['warehouses'=>$warehouses,'customers'=>$customers,'products'=>$products]);
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
        $datas = $request->validate([
            'contact_id.*'=>'required',
            'product_id.*'=>'required',
            'warehouse_id.*'=>'required',
            'created_date'=>'required',
            'quantity.*'=>'required',
            'total.*'=>'required'
          ]);

          
      
       $rowCount = count($datas['contact_id']);
          $purchaseData = [];

       for($i=0;$i<$rowCount;$i++)
       {
        $row=[];
        foreach($datas as $key=>$value)
        {
            if($key=='created_date'){
                $row[$key] = $value;
            }
            else
            {
                $row[$key] = $value[$i];
            }
          
            
        
        }
        $purchaseData[] = $row;


       }
   
       DB::beginTransaction();
    foreach($purchaseData as $data)
    {

      // Begin transaction
  
          try{
            // dd($request->toArray());

            $purchaseSale = new PurchaseSale([
      
              'warehouse_id'=>$data['warehouse_id'],
                'product_id'=>$data['product_id'],
                'quantiy'=>$data['quantity'],
                'type'=>'purchase',
                'contact_id'=>$data['contact_id'],
                'office_id'=>$branch?$branch:null,
            
            
            ]);
            $purchaseSale->save();
      
          $transcation = new  Transcation([
            'type'=>"in",
            'quantity'=>$data['quantity'],
            'amount'=>$data['total'],
            'warehouse_id'=>$data['warehouse_id'],
            'contact_id'=>$data['contact_id'],//not necessary 
            'product_id'=>$data['product_id'],
            'user_id'=>Auth::user()->id,
            'created_date'=>$data['created_date'],
            'office_id'=>$branch?$branch:null,
            'purchaseSale_id' =>$purchaseSale->id,
          ]);
      
          // dd($transcation);
          $transcation->save();
     

          }
          catch(\Exception $e){

        DB::rollback();
            return  back()->withSuccess("Fail to purchase");
            }
              

        }
        DB::commit();
        return  back()->withSuccess("Product has been purchased....");
     
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
    public function destroy(Request $request)
    {
        //deleting purchase info from purchase and sale table
     $id = $request->route('purchase');
        try{
            PurchaseSale::where('id',$id)->delete();
            return back()->withSuccess('Purchase details Deleted Successfully'); 
       }catch(Exception $e){
        return back()->withError('Failed to delete'); 
       }
    

    }
}
