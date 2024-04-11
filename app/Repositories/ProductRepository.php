<?php
namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\Office;
use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;
use App\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface{

  public function getAll(){
    return Product::with('category','unit')->get();

  }
  public function getById(string $id){

     $product =  Product::with('category','unit')->find($id);
    $categories = Category::all();
    $units = Unit::all();
    return [

      'product' =>$product,
      'categories'=>$categories,
      'units'=>$units,
    ];

  }
   public function getProductsofBranch($id)
   {
     $branchId = $id;
     $branch = Office::findOrFail($branchId);

     // Initialize an array to store product IDs
     $productWarehouses = [];
 
     // Retrieve the warehouses associated with the branch
     $warehouses = $branch->warehouse;
    //  dd($warehouses->toArray());
 
     // Loop through each warehouse
     foreach ($warehouses as $warehouse) {
          // Retrieve the product IDs associated with the current warehouse
         $productWarehouse = $warehouse->warehouse_has_product()->get()->toArray();

         // Merge the product IDs into the main array
         $productWarehouses = array_merge($productWarehouses, $productWarehouse);

   }
//  dd($productWarehouses);

   $AllproductsArray = [];
   
  
   foreach($productWarehouses as $productWarehouse)
   {
     
        $productsArray = [];
$productid = $productWarehouse['product_id'];
$warehouseid = $productWarehouse['warehouse_id'];

$warehouses =  Warehouse::where('id',$warehouseid)->get()->toArray()[0];
$productsArray['warehouse'] = $warehouses['name'];

    $products =  Product::where('id',$productid)->get()->toArray()[0];
    $productsArray['name'] = $products['name'];
    $productsArray['rate'] = $products['rate'];

    $category = Category::where('id',$products['category_id'])->get()->toArray()[0]['name'];
    $productsArray['category'] = $category;
    $unit = Unit::where('id',$products['unit_id'])->get()->toArray()[0]['name'];
    $productsArray['unit'] = $unit;

    $productsArray['quantity'] = $productWarehouse['quantity'];

    $AllproductsArray[] = $productsArray;
    

   }
   
  
return $AllproductsArray;
   
  }
  public function update(Request $request, string $id)
  {
    $request->validate([
      'name'=>'required|unique:products,name,' . $id ,
      'rate'=>'required|numeric',
      'category'=>'required',
      'unit'=>'required',
    ]);
    $product = Product::findorFail($id);
    $product->update($request->only(['name', 'rate', 'category', 'unit']));
  //   $product->name= $request->input('name');
  //   $product->rate= $request->input('rate');
  //   $product->category_id= $request->input('category');
  //   $product->unit_id= $request->input('unit');

  // $product->save();
  return true;



  }
  public function store(Request $request){

    $request->validate([
      'name'=>'required|unique:products',
      'rate'=>'required|numeric',
      'category'=>'required',
      'unit'=>'required',
      'date'=>'required',
    ]);
    $product = new  Product([
      'name'=>$request->name,
      'rate'=>$request->rate,
      'category_id'=>$request->category,
      'unit_id'=>$request->unit,
      'created_date'=>$request->date,

      

  ]);
  $product->save();
  return true;



  }
  public function delete(string $id){

    return Product::where('id',$id)->delete();

  }


}