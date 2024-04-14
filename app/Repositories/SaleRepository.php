<?php
namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Transcation;
use App\Models\PurchaseSale;
use App\Models\Office;
use App\Models\Warehouse_has_Product;

use App\Interfaces\SaleRepositoryInterface;

class SaleRepository implements SaleRepositoryInterface{

  public function getAll()
  {

     
  }
  public function getById(string $id)
  {
    //return warehouses of branch  with id =$id and also supplier and customer
    $branches = Office::with( 'warehouse')->find($id);
    //return warehouse of given branch
    return $branches->warehouse;


  }
  public function update(Request $request, string $id)
  {

  }
  
  public function show(int $id,Request $request)
  {
    //here id means branch id
      if($id)
      {
        return  PurchaseSale::with('warehouse','product','office','contact')->where('office_id',$id)->get();

      }
      else 
      {
        return  PurchaseSale::with('warehouse','product','office','contact')->whereNull('office_id')->get();
    
      }

  }
  public function store(Request $request,int $branch)
  {
    
    try{

      if($request->available_quantity)
      {

        if($request->quantity<=$request->available_quantity)
        {

          $purchaseSale = new PurchaseSale([

            'warehouse_id'=>$request->warehouse,
              'product_id'=>$request->product,
              'quantiy'=>$request->quantity,
              'type'=>'sale',
              'contact_id'=>$request->contact,
              'office_id'=>$branch?$branch:null,
          
          
          ]);
          $purchaseSale->save();
    
          $transcation = new  Transcation([
            'type'=>"out",
            'quantity'=>$request->quantity,
            'amount'=>$request->total,
            'warehouse_id'=>$request->warehouse,
            'contact_id'=>$request->contact,//not necessary 
            'product_id'=>$request->product,
            'user_id'=>1,
            'created_date'=>$request->date,
            'office_id'=>$branch?$branch:null,
            'purchaseSale_id' => $purchaseSale->id,
          ]);
      
          // dd($transcation);
          $transcation->save();
    
    
          return "Product has been sold..";

        }
        else
        {
          return 'Quantity exceed';
        }
      }
      else
      {
        return 'The quantity is not present in warehouse';
      }
   
    
    }
catch(\Exception $e){

  return "Transcation failed";
  }






    

  }
  public function delete(string $id)
  {
    try{
      PurchaseSale::where('id',$id)->delete();
     return true;
 }catch(Exception $e){
     return false;
 }

  }


}