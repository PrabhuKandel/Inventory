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
      return  PurchaseSale::with('warehouse','product','office','contact')->where('office_id',$id)->get();

    }
    else 
    {
      return  PurchaseSale::with('warehouse','product','office','contact')->whereNull('office_id')->get();
  
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

        'warehouse_id'=>$request->warehouse,
          'product_id'=>$request->product,
          'quantiy'=>$request->quantity,
          'type'=>'purchase',
          'contact_id'=>$request->contact,
          'office_id'=>$branch?$branch:null,
      
      
      ]);
      $purchaseSale->save();

    $transcation = new  Transcation([
      'type'=>"in",
      'quantity'=>$request->quantity,
      'amount'=>$request->total,
      'warehouse_id'=>$request->warehouse,
      'contact_id'=>$request->contact,//not necessary 
      'product_id'=>$request->product,
      'user_id'=>1,
      'created_date'=>$request->date,
      'office_id'=>$branch?$branch:null,
      'purchaseSale_id' =>$purchaseSale->id,
    ]);

    // dd($transcation);
    $transcation->save();

  // Check if a record with the same combination of warehouse_id and product_id exists
$productWarehouse = Warehouse_has_Product::where('warehouse_id', $request->warehouse)
->where('product_id', $request->product)
->first();
if ($productWarehouse) {
  // If the record exists, update the quantity column
  $productWarehouse->quantity += $request->quantity;
  $productWarehouse->save();
} 
else
{
    //save in ware_ouse has products
  $productWarehouse = new Warehouse_has_Product([
    'warehouse_id'=>$request->warehouse,
    'product_id'=>$request->product,
    'quantity'=>$request->quantity,
  ]);
  $productWarehouse->save();

}

  
return true ;
    }
catch(\Exception $e){
  dd($e);
  return false;
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