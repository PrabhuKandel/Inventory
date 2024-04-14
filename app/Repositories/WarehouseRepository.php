<?php
namespace App\Repositories;
use App\Interfaces\WarehouseRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\Warehouse_has_Product;

class  WarehouseRepository implements WarehouseRepositoryInterface{


  
public function getAll(){

}
public function getWarehousesOfBranch($id)
{

  //returning warehouse according to branch 
  // $warehouses =  Product::with('category','unit')->find($id);
  if($id)
  {
    return Warehouse::where('office_id',$id)->get();

  }
  else
  {
    return Warehouse::whereNull('office_id')->get();

  }

}
public function getById(string $id){
  return Warehouse::findorFail($id);

}

public function update(Request $request, string $id){

  $request->validate([
    'name'=>'required|unique:warehouses,name,' . $id ,
    'address'=>'required',
   
  ]);
  $warehouse = Warehouse::findorFail($id);
  $warehouse->update($request->only(['name', 'address']));
  return true;



}
public function store(Request $request){

  $request->validate([
    'name'=>'required|unique:warehouses',
    'address'=>'required',
    'date'=>'required',
  ]);
  $warehouse = new  Warehouse([
    'name'=>$request->name,
    'address'=>$request->address,
    'office_id'=>$request->branch,//null will be set if it is adminstrator and branch id will be save if it is branch coming from hidden input
    'created_date'=>$request->date,

]);
$warehouse->save();
return true;

}
public function delete($id)
{

  try{
    Warehouse::where('id',$id)->delete();
 
    return true;

}
catch(\Exception $e){

  return false;
}

}
}

