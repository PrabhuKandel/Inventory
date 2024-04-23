<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\PurchaseSale;
use App\Models\Transcation;
use App\Repositories\TranscationRepository;
use App\Http\Middleware\BranchAccessMiddleware; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseandSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */ private $transcationRepo;

    public function __construct(Request $request, TranscationRepository $transcationRepo)
    {
    
    

        $this->branch = explode("/",$request->route()->uri)[0]=='branchs'?$request->route()->parameters['id']:false;
         $this->type = $request->route('type');
         $this->transcationRepo = $transcationRepo;
         

    }
    public function index()
    {
        $branch = $this->branch;
        $_type = $this->type;
        $transcation_type = $this->type=="sales"?"sale":"purchase";
        $purchasesDetails = PurchaseSale::where('office_id',$branch)->orWhereNull('office_id')->where('type',$transcation_type)->get();
        return view('administrator.sale_purchase.details',compact('branch','purchasesDetails','transcation_type','_type'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branch = $this->branch;
        $_type = $this->type;
        $warehouses =Warehouse::where('office_id',$branch)->orWhereNull('office_id')->get();
        $contact_type = $_type == 'sales'? "customer": "supplier";

        $contacts = Contact::where('type',$contact_type)->select('id','name')->get();
     
        $products = Product::all();
        //update this......
        return view('administrator.sale_purchase.create',compact('branch','_type'),['warehouses'=>$warehouses,'contacts'=>$contacts,'products'=>$products]);
    

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $branch = $this->branch;
        $_type = $this->type;
       
        $datas = $request->validate([
        
            'contact_id.*'=>'required',
            'product_id.*'=>'required',
            'warehouse_id.*'=>'required',
            'quantity.*'=>'required',
            'total.*'=>'required',
            'created_date'=>'required'
            
          ]);
          
              //managing data 
              $rowCount = count($datas['contact_id']);
              $transcationData = [];
    
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
            $transcationData[] = $row;
            
            
          }  
       
          //making common function for purchase and sale to store data in each loop
          function storeTranscation($data,$_type,$branch)
          {
           
            $purchaseSale = new PurchaseSale([
          
                'warehouse_id'=>$data['warehouse_id'],
                  'product_id'=>$data['product_id'],
                  'quantiy'=>$data['quantity'],
                  'type'=>$_type=='sales'?'sale':"purchase",
                  'contact_id'=>$data['contact_id'],
                  'office_id'=>$branch?$branch:null,
              
              
              ]);
              $purchaseSale->save();
        
              $transcation = new  Transcation([
                'type'=>$_type =="sales" ?"out":"in",
                'quantity'=>$data['quantity'],
                'amount'=>$data['total'],
                'warehouse_id'=>$data['warehouse_id'],
                'contact_id'=>$data['contact_id'],
                'product_id'=>$data['product_id'],
                'user_id'=>Auth::user()->id,
                'created_date'=>$data['created_date'],
                'office_id'=>$branch?$branch:null,
                'purchaseSale_id' => $purchaseSale->id,
              ]);
              $transcation->save();

          }
    
          // for storing sales information
          if($_type=="sales"){
          DB::beginTransaction();
          try{
    
          foreach($transcationData as $data)
            {
              
           
              $quantity = $this->transcationRepo->calculateAvailability($branch?$branch:0,$data['product_id'],$data['warehouse_id']);
    
              if($quantity)
              { 
    
                if($data['quantity']>$quantity)
                {
                  return back()->withSuccess("Quantity exceed...");
    
                }
                else
                {
    
                    storeTranscation($data,$_type,$branch);
            
                }
              }
            else
            {
              DB::rollback();
              return back()->withSuccess("The quantity is not present in warehouse..");
            }
            
          }
          DB::commit();
          return back()->withSuccess("Product has been sold..");
    
        }
        catch(\Exception $e)
        {
          DB::rollback();
          dd($e);
          return  back()->withSuccess("Fail to sell");
          }
        }
          //for storing purchase information 
          if($_type =="purchases")
          {
       DB::beginTransaction();
       foreach($transcationData as $data)
       {
     
             try{
   
            storeTranscation($data,$_type,$branch);
        
   
             }
             catch(\Exception $e){
   
           DB::rollback();
               return  back()->withSuccess("Fail to purchase");
               }
                 
   
           }
           DB::commit();
           return  back()->withSuccess("Product has been purchased....");
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $id = $request->route('typeId');
     
        try{
            PurchaseSale::where('id',$id)->delete();
            return back()->withSuccess(' Deleted Successfully'); 
       }catch(Exception $e){
        return back()->withError('Failed to delete'); 
       }
    
    }
}
