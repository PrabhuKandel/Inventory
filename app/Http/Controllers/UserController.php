<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Repositories\BranchRepository;
use App\Repositories\UserRepository;


class UserController extends Controller
{
    
    private $branchRepository;

    private UserRepository $userRepo;
    public function __construct(UserRepository $userRepo, BranchRepository  $branchRepository)
    {
        $this->branchRepository = $branchRepository;
       $this->userRepo  = $userRepo;

    }
     public function index()
    {
        $offices = $this->branchRepository->getAll();
        $roles = Role::all();
        return view('administrator.user.create_user',['offices'=>$offices,'roles'=>$roles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    
 /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required',
            'email'=>'required|unique:users',
            'password'=>'required',
            'address'=>'required',
            'created_date'=>'required',
            'role_id'=>'required',
            'office_id'=>'required'
          ]);
          $data['password'] = Hash::make($data['password']);

          $response = $this->userRepo->store($data);
      if($response)
      {

        return back()->withSuccess("User has been added");
      }
      else
      {
        return back()->withSuccess("Failed to create new user");
      }
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //        //here id is not of warehouse it is of branch like users/1 means users of branch 1
        dd('fd');
        return view('administrator.user.user_details');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('administrator.user.edit_user');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        dd($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->userRepo->delete($id);
        if($response){
            return back()->withSuccess('User deleted');
        }
        else {

            return back()->withError('Sorry cant delete user');
        }
    }
}
