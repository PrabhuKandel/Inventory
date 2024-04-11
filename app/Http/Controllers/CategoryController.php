<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryController extends Controller
{
    private CategoryRepositoryInterface $categoryRepo;
     public function __construct(CategoryRepositoryInterface $categoryRepo)

     {

        $this->categoryRepo  = $categoryRepo;

     }
    public function index()
    {
        $categories = $this->categoryRepo->getAll();
        return view('administrator.category.category_details',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('administrator.category.create_category');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
       $response =  $this->categoryRepo->store($request);

       if($response)
       {

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
        $category = $this->categoryRepo->getById($id);
      
        return view('administrator.category.edit_category',['category'=>$category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      
        $response = $this->categoryRepo->update( $request , $id);

        if($response)
        {

            return back()->withSuccess('Category Updated Successfully !!!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->categoryRepo->delete($id);
        if($response)
        {
            return back()->withSuccess('Category Deleted Successfully!');
        }
    }
}
