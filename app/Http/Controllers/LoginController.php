<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Office;

class loginController extends Controller
{
    public function index()
    {
    
        return view('login.login');
    }
    public function submit(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        $credentials = $request->only('email', 'password');
     
        if (Auth::attempt($credentials)){
         $email = $request->email;
         $user = User::where('email', $email)->with('office')->first();

           

                $request->session()->regenerate();

                if($user->office)
                {
                    return redirect()->intended('branchs/'.$user->office_id. '/dashboards');
                }

                else
                {

                    return redirect()->intended('dashboards');
                }
                

            }
             
            else
            {
                return back()->withError("User not found with given credentials");
            }
        }


      
       

    }


