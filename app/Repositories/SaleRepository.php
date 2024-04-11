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
      // dd($request->toArray());

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
    ]);

    // dd($transcation);
    $transcation->save();


$purchaseSale = new PurchaseSale([

  'warehouse_id'=>$request->warehouse,
    'product_id'=>$request->product,
    'quantiy'=>$request->quantity,
    'type'=>'sale',
    'contact_id'=>$request->contact,
    'office_id'=>$branch?$branch:null,


]);
$purchaseSale->save();
  
return true ;
    }
catch(\Exception $e){
dd($e);
  return false;
  }


//   // Check if a record with the same combination of warehouse_id and product_id exists
// $productWarehouse = Warehouse_has_Product::where('warehouse_id', $request->warehouse)
// ->where('product_id', $request->product)
// ->first();

//check if product is present in particular warehouse

//   if ($productWarehouse) {
//     //if product present there update there
//     if($request->quantity<= $productWarehouse->quantity)
//     {
  
    
//     // If the record exists, update the quantity column
//     $productWarehouse->quantity -= $request->quantity;
//     $productWarehouse->save();
//     return true;
//     }
//     else{
//   //else quantity amount exceed
//       return false;
//     }
//   } 
//   else
//   {
//     //if product isnot present in warehouse
//    dd("product not present in this warehouse");
//   }




    

  }
  public function delete(string $id)
  {

  }


}