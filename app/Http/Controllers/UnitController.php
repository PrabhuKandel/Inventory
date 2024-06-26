<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CommonRepository;
use App\Models\Unit;
use App\Http\Middleware\BranchAccessMiddleware;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */ private $branch;
    private  $commonRepo;
    public function __construct(Request $request)

    {

        $this->middleware(BranchAccessMiddleware::class);
        $this->middleware('permission:view-unit|create-unit|edit-unit|delete-unit')->only('index');
        $this->middleware('permission:create-unit|edit-unit', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-unit|delete-unit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-unit', ['only' => ['destroy']]);
        $this->branch = explode("/", $request->route()->uri)[0] == 'branchs' && $request->route()->hasParameter('id') ? $request->route()->parameters['id'] : false;
        $this->commonRepo  = new CommonRepository(new Unit());
    }

    public function index()
    {
        $branch = $this->branch;
        $units = $this->commonRepo->getAll();
        return view('administrator.unit.unit_details', compact('units', 'branch'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branch = $this->branch;
        return view('administrator.unit.create_unit', compact('branch'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data =  $request->validate([

            'name' => 'required|string|unique:units',
            'description' => 'required|string',
            'created_date' => 'date|required',
        ]);
        $response =  $this->commonRepo->store($data);

        if ($response) {

            return back()->withSuccess('New Unit created !!!!');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $branch = $this->branch;
        $unitId = $request->route('unit');
        $unit = $this->commonRepo->find($unitId);

        return view('administrator.unit.view_unit', compact('unit', 'branch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $branch = $this->branch;
        $unit = $this->commonRepo->find($id);
        return view('administrator.unit.create_unit', ['unit' => $unit], compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([

            'name' => 'required|string|unique:units,name,' . $id,
            'description' => 'required|string',
        ]);

        $response = $this->commonRepo->update($data, $id);

        if ($response) {

            return back()->withSuccess('Unit Updated Successfully !!!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->commonRepo->delete($id);


        if ($response) {
            return back()->withSuccess('Unit Deleted Successfully!');
        } else {
            return back()->withError(' Sorry can\'t delete, Unit is being used!');
        }
    }
}
