<?php
namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Interfaces\CategoryRepositoryInterface;


class CategoryRepository implements CategoryRepositoryInterface{

  public function getAll()
  {

     return Category::all();
  }
  public function getById(string $id)
  {
    //use for editing or updating
    return Category::findorFail($id);

  }
  public function update(Request $request, string $id)
  {
    $request->validate([

      'name' => 'required|string|unique:categories,name,'.$id,
      'description' => 'required|string',
  ]);
  $category = Category::findorFail($id);
 

  $category->name = $request->input('name');
  $category->description = $request->input('description');
     // Save the updated contact record
     $category->save();
     return true;
  }
  public function store(Request $request)
  {

      $request->validate([

          'name' => 'required|string|unique:categories',
          'description' => 'required|string',
          'date'=>'date|required',
      ]);

      $category = new Category([
          'name'=>$request->name,
          'description'=>$request->description,
          'created_date'=>$request->date,
      ]);
      $category->save();
      return true;


  }
  public function delete(string $id)
  {

    try{
      Category::where('id',$id)->delete();
   
      return true;
  
  }
  catch(\Exception $e){

    return false;
  }


}
}