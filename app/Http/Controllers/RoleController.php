<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Repositories\CommonRepository;
use App\Http\Middleware\BranchAccessMiddleware; 
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    private  $roleRepo;
     public function __construct()

     {
        $this->middleware(BranchAccessMiddleware::class);
        $this->middleware('permission:view-role|create-role|edit-role|delete-role')->only('index');
        $this->middleware('permission:create-role|edit-role', ['only' => ['create','store']]);
        $this->middleware('permission:edit-role|delete-role', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-role', ['only'=> ['destroy']]);
      

        $this->roleRepo  = new CommonRepository(new Role());
     }

    public function index()
    {

       $roles =  $this->roleRepo->getAll();
        return view('administrator.role.role_details',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $permissions = Permission::all();
        return view('administrator.role.create_role',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'name'=>'required',
            'permissions.*'=>'required',


        ]);

        DB::beginTransaction();
        try{
        $role = Role::create(['name'=>$data['name']]);
        $permissions = Permission::whereIn('id',$data['permissions'])->pluck('name')->toArray();
        $role->givePermissionTo($permissions);
        DB::commit();
        return back()->withSuccess('New role created');
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return back()->withSuccess('Failed to create new role');
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
    public function edit( $id)
    {
       
        $role = $this->roleRepo->find($id);
        $assignedPermissions = $role->permissions()->pluck('id')->toArray();
        $permissions = Permission::all();
        return view('administrator.role.create_role',compact('role','permissions','assignedPermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)

    {
  
        //
        $data = $request->validate([
            'name'=>'required',
            'permissions.*'=>'required',


        ]);
        DB::beginTransaction();
        try{
      $role =  $this->roleRepo->find($id);
      $role->update(['name'=>$data['name']]);
      $permissions = Permission::whereIn('id',$data['permissions'])->pluck('name')->toArray();
       $role->syncPermissions($permissions);
       DB::commit();
       return back()->withSuccess('Role has been updated successfully');
        }
        catch(\Exception $e){
            DB::rollback();
            return back()->withSuccess('Updation failed....');
        }
   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id,Request $request)
    {
        //
       $role = Role::where('id',$id)->get();
       if($role[0]->name == 'Super Admin'||$role[0]->users()->exists())
       {
        return back()->withSuccess("Can't delete role");
       }
        $res = $this->roleRepo->delete($id);
        $res?$msg = 'Role destroyed':$msg =  "Action Failed";
        return back()->withSuccess($msg);

    }
}
