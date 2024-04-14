<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\BranchRepositoryInterface;
use App\Models\Office;
use Illuminate\Support\Facades\Session;


class BranchController extends Controller
{
   
public $branch;
    private BranchRepositoryInterface $branchRepository;
    public function __construct(BranchRepositoryInterface $branchRepository,Request $request ){

            $this->branchRepository = $branchRepository;


    }

    public function index(Request $request)
    {
       $branches = $this->branchRepository->getAll();
       $branch = explode("/",$request->route()->uri)[0]=='branchs' && isset($request->route()->parameters['id'])?$request->route()->parameters['id']:false;
       return view('administrator.branch.branch_details',compact('branches', 'branch'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('administrator.branch.create_branch');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //branch details will be stored

        
     $response =  $this->branchRepository->store($request); 
                 
         if($response)
         {
         return back()->withSuccess('Branch created !!!!');
         }
        
        
       
       
        }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    
    {
       //change url to branch/{id}//not used
     
        
        $branch = explode("/",$request->route()->uri)[0]=='branchs'?$request->route()->parameters['branch']:false;
        $branches = $this->branchRepository->getAll();
        return view('administrator.branch.branch_details',compact('branches', 'branch'));

        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Request $request)
    {
                
        $branch = explode("/",$request->route()->uri)[0]=='branchs'?$request->route()->parameters['branch']:false;
        $branch1 = $this->branchRepository->getById($branch);

         return view('administrator.branch.edit_branch',['branch1'=>$branch1],compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( int $id,Request $request)
    {
        
    
        $response = $this->branchRepository->update( $request ,$id);

        if($response)
        {

            return back()->withSuccess('Office details changed !!!!');
        }
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
            $response = $this->branchRepository->delete($id);
            if($response)
            {

                return back()->withSuccess("Branch successfully deleted");
            }
            else
            {
                return back()->withSuccess("Failed to delete");
            }
      
    }
}
