<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\UserRepositoryInterface;


class UserController extends Controller
{
    

    private UserRepositoryInterface $userRepo;
    public function __construct(UserRepositoryInterface $userRepo)

    {

       $this->userRepo  = $userRepo;

    }
     public function index()
    {
        $offices = $this->userRepo->allOffice();
        $roles =  $this->userRepo->getRole();
        return view('administrator.user.create_user',['offices'=>$offices,'roles'=>$roles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    
    public function getUsersOfBranch($id, Request $request)
    {
        $branch = explode("/",$request->route()->uri)[0]=='branchs'?$request->route()->parameters['id']:false;
        $users = $this->userRepo->getUsersOfBranch($id);
        return view('administrator.user.user_details',compact('users','branch'));
        // dd($products);
    }
 /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $response = $this->userRepo->store($request);
      if($response)
      {

        return back()->withSuccess("User has been added");
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
