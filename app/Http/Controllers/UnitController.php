<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UnitRepository;
use App\Models\Unit;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private  $unitRepo;
    public function __construct(UnitRepository $unitRepo)

    {

       $this->unitRepo  = $unitRepo;

    }

    public function index()
    {
        $units = $this->unitRepo->getAll();
        return view('administrator.unit.unit_details',compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('administrator.unit.create_unit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
       $data =  $request->validate([

            'name' => 'required|string|unique:units',
            'description' => 'required|string',
            'created_date'=>'date|required',
        ]);
        $response =  $this->unitRepo->store($data);

        if($response)
        {
 
         return back()->withSuccess('New Unit created !!!!');
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $unit = $this->unitRepo->find($id);
        return view('administrator.unit.edit_unit',['unit'=>$unit]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([

            'name' => 'required|string|unique:units,name,'.$id,
            'description' => 'required|string',
        ]);
        
        $response = $this->unitRepo->update( $data , $id);

        if($response)
        {

            return back()->withSuccess('Unit Updated Successfully !!!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->unitRepo->delete($id);
     

        if($response)
        {
            return back()->withSuccess('Unit Deleted Successfully!');
        }
        else{
            return back()->withError(' Sorry can\'t delete, Unit is being used!');

        }
    }
}
