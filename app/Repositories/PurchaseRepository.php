<?php
namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Transcation;
use App\Models\Office;
use App\Models\Warehouse_has_Product;
use App\Models\PurchaseSale;
use App\Interfaces\PurchaseRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PurchaseRepository implements PurchaseRepositoryInterface{

  public function getAll()
  {

     
  }
  public function show (string $id){

    if($id)
    {
      return  PurchaseSale::where('office_id',$id)->get();

    }
    else 
    {
      return  PurchaseSale::whereNull('office_id')->get();
  
    }
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
  public function store(Request $request, string $branch)
  {
    

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
      'created_date'=>$request->date,
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