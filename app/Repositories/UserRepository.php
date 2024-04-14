<?php
namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Office;
use App\Models\Role;
use App\Models\Office_has_User;
use App\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface{

  public function getAll()
  {
     
  }
  public function allOffice()
  {

    return Office::all();
  }
  public function getRole()
  {

    return Role::all();
  }
  public function getById(string $id){

  }


  public function getUsersOfBranch( $id)
  {

   $UsersId =  Office_has_User::where('office_id',$id)->pluck('user_id');
   
   $Users=[];
   foreach($UsersId as $UserId)
   {
     $user =  User::where( 'id' , $UserId )->get();
     $Users[] = $user[0];
   }
   return $Users;
  }
  public function update(Request $request, string $id){


  }
  public function store(Request $request){

    $request->validate([
      'name'=>'required',
      'email'=>'required|unique:users',
      'password'=>'required',
      'address'=>'required',
      'date'=>'required',
      'role'=>'required',
      'branches'=>'required'
    ]);
    
    $user = new  User([
      'name'=>$request->name,
      'email'=>$request->email,
      'password'=>$request->password,
      'address'=>$request->address,
      'role_id'=>$request->role,
      'created_date'=>$request->date,
  ]);
  $user->save();
  
// Retrieve the user based on the email address
$user = User::where('email', $request->email)->first();

  //also save in Office_has_users table
  foreach($request->branches as $branch)
{
  $officeUser = new Office_has_User();
  $officeUser->office_id  = $branch;
  $officeUser->user_id = $user->id;
  
  $officeUser->save();
}
return true;

  
  }
  public function delete($id)
  {
    try{
      User::where('id',$id)->delete();
   
      return true;
  
  }
  catch(\Exception $e){

    return false;
  }


  }
  


}