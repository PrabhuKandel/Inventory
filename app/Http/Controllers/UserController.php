<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Office;
use App\Repositories\CommonRepository;
use App\Http\Middleware\BranchAccessMiddleware;
use Spatie\Permission\Models\Permission;
use Validator;

class UserController extends Controller
{

  private $branch;
  private $branchRepository;
  private  $userRepo;
  public function __construct(Request $request)
  {
    $this->middleware(BranchAccessMiddleware::class);
    $this->branch = explode("/", $request->route()->uri)[0] == 'branchs' ? $request->route()->parameters['id'] : false;
    $this->middleware('permission:view-user|create-user|edit-user|delete-user')->only('index');
    $this->middleware('permission:create-user|edit-user', ['only' => ['create', 'store']]);
    $this->middleware('permission:edit-user|delete-user', ['only' => ['edit', 'update']]);
    $this->middleware('permission:delete-user', ['only' => ['destroy']]);
    $this->branchRepository = new CommonRepository(new Office());
    $this->userRepo  = new CommonRepository(new  User());
  }
  public function index(Request $request)
  {
    $branch = $this->branch;
    $users = $this->userRepo->getAll();

    return view('administrator.user.user_details', compact('users', 'branch'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $branch = $this->branch;
    $offices = $this->branchRepository->getAll();
    $roles = Role::all();
    return view('administrator.user.create_user', ['offices' => $offices, 'roles' => $roles], compact('branch'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $data = $request->validate([
      'name' => 'required',
      'email' => 'required|unique:users',
      'password' => 'required',
      'address' => 'required',
      'created_date' => 'required',
      'office_id' => 'nullable',
      'role_id' => 'required',

    ]);

    $data['password'] = Hash::make($data['password']);
    $role_id = $data['role_id'];
    unset($data['role_id']);
    $response = $this->userRepo->store($data);
    if ($response) {
      //assigning roles to user
      $user = User::where('email', $data['email'])->first();
      $role = Role::where('id', (int) $role_id)->first();
      $user->syncRoles($role);

      return back()->withSuccess("User has been added");
    } else {
      return back()->withSuccess("Failed to create new user");
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id, Request $request)
  {
    $branch = $this->branch;
    $userId = $request->route('user');
    $user = $this->userRepo->find($userId);
    //finding products in that warehouse
    return view('administrator.user.view_user', compact('user', 'branch'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id, Request $request)
  {
    $user = $this->userRepo->find($id);
    $branch = $this->branch;
    $offices = $this->branchRepository->getAll();
    $roles = Role::all();
    return view('administrator.user.create_user', compact('user', 'offices', 'roles', 'branch'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $data = $request->validate([
      'name' => 'required',
      'email' => 'required|unique:users,email,' . $id,
      'address' => 'required',
      'office_id' => 'nullable',
      'role_id' => 'required',

    ]);
    $role_id = $data['role_id'];
    unset($data['role_id']);
    $response = $this->userRepo->update($data, $id);
    if ($response) {
      //assigning roles to user
      $user = User::where('email', $data['email'])->first();
      $role = Role::where('id', (int) $role_id)->first();
      $user->syncRoles($role);

      return back()->withSuccess("User info has been updated");
    } else {
      return back()->withSuccess("Updation failed...");
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $response = $this->userRepo->delete($id);
    if ($response) {
      return back()->withSuccess('User deleted');
    } else {

      return back()->withError('Sorry cant delete user');
    }
  }
}
