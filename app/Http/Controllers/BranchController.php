<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CommonRepository;
use App\Models\Office;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\BranchAccessMiddleware;
use App\Http\Requests\BranchRequest;

class BranchController extends Controller
{

    public $branch;
    private  $commonRepo;
    public function __construct(Request $request)
    {

        $this->commonRepo = new CommonRepository(new Office());
        $this->middleware(BranchAccessMiddleware::class);
        $this->middleware('permission:view-branch|create-branch|edit-branch|delete-branch')->only('index');
        $this->middleware('permission:create-branch|edit-branch', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-branch|delete-branch', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-branch', ['only' => ['destroy']]);
        $this->branch = explode("/", $request->route()->uri)[0] == 'branchs' && $request->route()->hasParameter('branch') ? $request->route()->parameters['branch'] : false;
    }
    public function index(Request $request)
    {
        $user = Auth::user();
        // Dump the user's permissions
        $branches = $this->commonRepo->getAll();
        $branch = explode("/", $request->route()->uri)[0] == 'branchs' && isset($request->route()->parameters['id']) ? $request->route()->parameters['id'] : false;
        return view('administrator.branch.branch_details', compact('branches', 'branch'));
    }

    public function create()
    {
        //
        $branch = $this->branch;
        return view('administrator.branch.create_branch', compact('branch'));
    }


    public function store(BranchRequest $request)
    {
        //branch details will be stored
        $data = $request->validated();



        $response =  $this->commonRepo->store($data);


        if ($response) {
            return back()->withSuccess('Branch created !!!!');
        } else {
            return back()->withSuccess('Failed to create');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)

    {
        $branch = $this->branch;

        $branchDetail = $this->commonRepo->find($id);
        //finding products in that warehouse
        return view('administrator.branch.view_branch', compact('branchDetail'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Request $request)
    {

        $branch = $this->branch;
        $branch1 = $this->commonRepo->find($id);

        return view('administrator.branch.create_branch', ['branch1' => $branch1]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, BranchRequest $request)
    {
        $data = $request->validated();


        $response = $this->commonRepo->update($data, $id);

        if ($response) {

            return back()->withSuccess('Office details changed !!!!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $response = $this->commonRepo->delete($id);
        if ($response) {

            return back()->withSuccess("Branch successfully deleted");
        } else {
            return back()->withSuccess("Failed to delete");
        }
    }
}
