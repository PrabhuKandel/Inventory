<?php
namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Product;
use App\Interfaces\UnitRepositoryInterface;

class UnitRepository implements UnitRepositoryInterface{

  public function getAll()
  {

     return Unit::all();
  }
  public function getById(string $id)
  {
    //use for editing or updating
    return Unit::findorFail($id);

  }
  public function update(Request $request, string $id)
  {
    $request->validate([

      'name' => 'required|string|unique:units,name,'.$id,
      'description' => 'required|string',
  ]);
  $unit = Unit::findorFail($id);
 

  $unit->name = $request->input('name');
  $unit->description = $request->input('description');
     // Save the updated contact record
     $unit->save();
     return true;
  }
  public function store(Request $request)
  {

      $request->validate([

          'name' => 'required|string|unique:units',
          'description' => 'required|string',
          'date'=>'date|required',
      ]);

      $unit = new Unit([
          'name'=>$request->name,
          'description'=>$request->description,
          'created_date'=>$request->date,
      ]);
      $unit->save();
      return true;


  }
  public function delete(string $id)
  {
    try{
      Unit::where('id',$id)->delete();
   
      return true;
  
  }
  catch(\Exception $e){

    return false;
  }
  }


}