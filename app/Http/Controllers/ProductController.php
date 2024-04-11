<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\UnitRepositoryInterface;

class ProductController extends Controller
{

    private ProductRepositoryInterface $productRepo;
    private CategoryRepositoryInterface $categoryRepo;
    private UnitRepositoryInterface $unitRepo;
    public function __construct(ProductRepositoryInterface $productRepo,CategoryRepositoryInterface $categoryRepo,
    UnitRepositoryInterface $unitRepo)
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
    public function listedProducts()
    {
      
      
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


    public function getProductsOfBranch($id ,Request $request)
    {
        $branchId = $id;
        $branch = explode("/",$request->route()->uri)[0]=='branchs'?$request->route()->parameters['id']:false;
        $products = $this->productRepo->getProductsOfBranch($id);
        // dd($products);
        return view('administrator.view_product.view_products',['branchId'=>$branchId, 'products' => $products],compact('branch'));


    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = $this->productRepo->store($request); 
                 
        if($response)
        {
            return back()->withSuccess('Product created !!!!');

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id ,Request $request)
    {
        $branch = explode("/",$request->route()->uri)[0]=='branchs'?$request->route()->parameters['id']:false;
        $products = $this->productRepo->getAll();
    
        return view('administrator.product.product_details',compact('products','branch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)

    {

        $data = $this->productRepo->getById($id);
        $product = $data['product'];
        $categories =$data['categories'];
        $units = $data['units'];

       
        return view('administrator.product.edit_product',['product'=>$product],compact('categories','units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $response = $this->productRepo->update($request , $id);

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
    }
}
