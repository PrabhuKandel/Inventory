<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\UnitRepository;

class ProductController extends Controller
{

    private  $productRepo;
    private  $categoryRepo;
    private  $unitRepo;
    public function __construct(ProductRepository $productRepo,CategoryRepository $categoryRepo,
    UnitRepository $unitRepo)
    {
        $this->productRepo = $productRepo;
        $this->categoryRepo = $categoryRepo;
        $this->unitRepo = $unitRepo;
    }


     
    public function index()
    {
       
        $products = $this->productRepo->getAll();

        return view('administrator.product.product_details',compact('products'));
    }
   
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
           $categories = $this->categoryRepo->getAll();
        $units = $this->unitRepo->getAll();
        return view('administrator.product.create_product',compact('categories','units'));
    }


   
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data =   $request->validate([
            'name'=>'required|unique:products',
            'rate'=>'required|numeric',
            'category_id'=>'required',
            'unit_id'=>'required',
            'created_date'=>'required',
          ]);
          
        $response = $this->productRepo->store($data); 
                 
        if($response)
        {
            return back()->withSuccess('Product created !!!!');

        }
        else
        {
            return back()->withSuccess('Failed to create product !!!!'); 
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id ,Request $request)
    {
        //show products for each branch
        $branch = explode("/",$request->route()->uri)[0]=='branchs'?$request->route()->parameters['id']:false;
        $products = $this->productRepo->getAll();
    
        return view('administrator.product.product_details',compact('products','branch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)

    {

        $product = $this->productRepo->find($id);
        $categories =$this->categoryRepo->getAll();
        $units =$this->unitRepo->getAll();

       
        return view('administrator.product.edit_product',['product'=>$product],compact('categories','units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data =   $request->validate([
            'name'=>'required|unique:products',
            'rate'=>'required|numeric',
            'category_id'=>'required',
            'unit_id'=>'required',
            'created_date'=>'required',
          ]);
        $response = $this->productRepo->update($data , $id);

        if($response)
        {
            return back()->withSuccess('Product  details  updated successfully!') ;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->productRepo->delete($id);

        if($response)
        {
            return back()->withSuccess('Product deleted');
        }
        else
        {
            return back()->withSuccess('Product deletion failed');
        }
    }
}
