<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Category;
use App\Repositories\CommonRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\UnitRepository;
use App\Http\Middleware\BranchAccessMiddleware;

class ProductController extends Controller
{

    private  $productRepo;
    private  $categoryRepo;
    private  $unitRepo;
    private  $branch;
    public function __construct(Request $request)
    {
        $this->middleware(BranchAccessMiddleware::class);
        $this->middleware('permission:view-product|create-product|edit-product|delete-product')->only('index');
        $this->middleware('permission:create-product|edit-product', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-product|delete-product', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-product', ['only' => ['destroy']]);
        $this->branch = explode("/", $request->route()->uri)[0] == 'branchs' ? $request->route()->parameters['id'] : false;
        $this->productRepo = new CommonRepository(new Product());
        $this->categoryRepo = new CommonRepository(new Category());
        $this->unitRepo = new CommonRepository(new Unit());
    }



    public function index()
    {

        $products = $this->productRepo->getAll();
        $branch = $this->branch;

        return view('administrator.product.product_details', compact('products', 'branch'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->categoryRepo->getAll();
        $units = $this->unitRepo->getAll();
        return view('administrator.product.create_product', compact('categories', 'units'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data =   $request->validate([
            'name' => 'required|unique:products',
            'rate' => 'required|numeric',
            'category_id' => 'required',
            'unit_id' => 'required',
            'created_date' => 'required',
        ]);

        $response = $this->productRepo->store($data);

        if ($response) {
            return back()->withSuccess('Product created !!!!');
        } else {
            return back()->withSuccess('Failed to create product !!!!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $branch = $this->branch;
        $productId = $request->route('product');
        $product = $this->productRepo->find($productId);

        return view('administrator.product.view_product', compact('product', 'branch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)

    {

        $product = $this->productRepo->find($id);

        $categories = $this->categoryRepo->getAll();
        $units = $this->unitRepo->getAll();


        return view('administrator.product.create_product', ['product' => $product], compact('categories', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data =   $request->validate([
            'name' => 'required|unique:products',
            'rate' => 'required|numeric',
            'category_id' => 'required',
            'unit_id' => 'required',
            'created_date' => 'required',
        ]);
        $response = $this->productRepo->update($data, $id);

        if ($response) {
            return back()->withSuccess('Product  details  updated successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->productRepo->delete($id);

        if ($response) {
            return back()->withSuccess('Product deleted');
        } else {
            return back()->withSuccess('Product deletion failed');
        }
    }
}
