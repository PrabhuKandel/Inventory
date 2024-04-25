<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CommonRepository;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\BranchAccessMiddleware;

class CategoryController extends Controller
{
    private  $commonRepo;
    private $categoryId;
    public function __construct(Request $request)

    {
        $this->categoryId = $request->route('category');
        $this->middleware(BranchAccessMiddleware::class);
        $this->middleware('permission:view-category|create-category|edit-category|delete-category')->only('index');
        $this->middleware('permission:create-category|edit-category', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-category|delete-category', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-category', ['only' => ['destroy']]);
        $this->commonRepo  = new CommonRepository(new Category());
    }
    public function index()
    {
        $categories = $this->commonRepo->getAll();

        return view('administrator.category.category_details', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categoryId = $this->categoryId;

        return view('administrator.category.create_category', compact('categoryId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data =  $request->validate([

            'name' => 'required|string|unique:categories',
            'description' => 'required|string',
            'created_date' => 'date|required',
        ]);

        $response =  $this->commonRepo->store($data);

        if ($response) {

            return back()->withSuccess('New Category created !!!!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $category = $this->commonRepo->find($id);

        $categoryId = $this->categoryId;
        return view('administrator.category.create_category', ['category' => $category], compact('categoryId'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data =  $request->validate([

            'name' => 'required|string|unique:categories,name,' . $id,
            'description' => 'required|string',
            'created_date' => 'date|required',
        ]);
        $response = $this->commonRepo->update($data, $id);

        if ($response) {

            return back()->withSuccess('Category Updated Successfully !!!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->commonRepo->delete($id);
        if ($response) {
            return back()->withSuccess('Category Deleted Successfully!');
        } else {
            return back()->withError(" Sorry can\'t delete, category is being used!");
        }
    }
}
