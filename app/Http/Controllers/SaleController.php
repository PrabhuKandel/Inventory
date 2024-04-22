<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TranscationRepository;
use App\Repositories\WarehouseRepository;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Transcation;
use App\Models\PurchaseSale;
use App\Http\Middleware\BranchAccessMiddleware; 
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    private  $warehouseRepo;
    private $transcationRepo;
    public function __construct(  WarehouseRepository $warehouseRepo, TranscationRepository $transcationRepo)
    {

      $this->middleware(BranchAccessMiddleware::class);
      $this->middleware('permission:view-sale|create-sale|edit-sale|delete-sale')->only('index');
      $this->middleware('permission:create-sale|edit-sale', ['only' => ['create','store']]);
      $this->middleware('permission:edit-sale|delete-sale', ['only' => ['edit','update']]);
      $this->middleware('permission:delete-sale', ['only' => ['destroy']]);
       $this->warehouseRepo = $warehouseRepo;
       $this->transcationRepo = $transcationRepo;

    }
    public function index(Request $request)
    {//branch id is needed
        $branch = explode("/",$request->route()->uri)[0]=='branchs'?$request->route()->parameters['id']:false;
        $salesDetails =$branch? PurchaseSale::where('office_id',$branch)->get():PurchaseSale::whereNull('office_id')->get();  
        
        return view('administrator.sale.sale_details',compact('branch','salesDetails'));
    }
    
    public function sale(Request $request)
    {

     
        $branch = explode("/",$request->route()->uri)[0]=='branchs'?$request->route()->parameters['id']:false;
        $warehouses =$branch? Warehouse::where('office_id',$branch)->get():Warehouse::whereNull('office_id')->get();
        $customers = Contact::where('type','customer')->select('id','name')->get();
        $products = Product::all();
        
        return view('administrator.sale.demo',compact('branch'),['warehouses'=>$warehouses,'customers'=>$customers,'products'=>$products]);
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
        'quantity.*'=>'required',
        'total.*'=>'required',
        'created_date'=>'required'
        
      ]);
      
      dd($datas);
    
//checking availability of product



          //managing data 
          $rowCount = count($datas['contact_id']);
          $sellData = [];

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
        $sellData[] = $row;
        
        
      }  
    

      // dd($sellData);
      DB::beginTransaction();
      try{

      foreach($sellData as $data)
        {
          
       
          $quantity = $this->transcationRepo->checkQuantity($branch?$branch:0,$data['product_id'],$data['warehouse_id']);

          if($quantity)
          {

            if($data['quantity']>$quantity)
            {
              return back()->withSuccess("Quantity exceed...");

            }
            else
            {


              $purchaseSale = new PurchaseSale([
      
                'warehouse_id'=>$data['warehouse_id'],
                  'product_id'=>$data['product_id'],
                  'quantiy'=>$data['quantity'],
                  'type'=>'sale',
                  'contact_id'=>$data['contact_id'],
                  'office_id'=>$branch?$branch:null,
              
              
              ]);
              $purchaseSale->save();
        
              $transcation = new  Transcation([
                'type'=>"out",
                'quantity'=>$data['quantity'],
                'amount'=>$data['total'],
                'warehouse_id'=>$data['warehouse_id'],
                'contact_id'=>$data['contact_id'],//not necessary 
                'product_id'=>$data['product_id'],
                'user_id'=>Auth::user()->id,
                'created_date'=>$data['created_date'],
                'office_id'=>$branch?$branch:null,
                'purchaseSale_id' => $purchaseSale->id,
              ]);
          
              // dd($transcation);
              $transcation->save();
        
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

      // $response = $this->transcationRepo->checkQuantity($branch?$branch:0,5,10);
      //     try{

      //       if($request->available_quantity)
      //       {
      
      //         if($request->quantity<=$request->available_quantity)
      //         {
      
      //           $purchaseSale = new PurchaseSale([
      
      //             'warehouse_id'=>$request->warehouse,
      //               'product_id'=>$request->product,
      //               'quantiy'=>$request->quantity,
      //               'type'=>'sale',
      //               'contact_id'=>$request->contact,
      //               'office_id'=>$branch?$branch:null,
                
                
      //           ]);
      //           $purchaseSale->save();
          
      //           $transcation = new  Transcation([
      //             'type'=>"out",
      //             'quantity'=>$request->quantity,
      //             'amount'=>$request->total,
      //             'warehouse_id'=>$request->warehouse,
      //             'contact_id'=>$request->contact,//not necessary 
      //             'product_id'=>$request->product,
      //             'user_id'=>Auth::user()->id,
      //             'created_date'=>$request->date,
      //             'office_id'=>$branch?$branch:null,
      //             'purchaseSale_id' => $purchaseSale->id,
      //           ]);
            
      //           // dd($transcation);
      //           $transcation->save();
          
          
      //           return back()->withSuccess("Product has been sold..");
      
      //         }
      //         else
      //         {
                
      //           return back()->withSuccess("Quantity exceed...");
      //         }
      //       }
      //       else
      //       {
            
      //           return back()->withSuccess("The quantity is not present in warehouse..");
      //       }
         
          
      //     }
      // catch(\Exception $e){
      
       
      //   return back()->withSuccess("Transcation failed..");
      //   }
      
      
      
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
    public function destroy(Request $request)
    {
    
      $id = $request->route('sale');
      
        try{
            PurchaseSale::where('id',$id)->delete();
            return back()->withSuccess('Sales details Deleted Successfully'); 
       }catch(Exception $e){
        return back()->withError('Failed to delete'); 
       }
    }
}
