<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

            $officeType = $user->office->type;
            if($officeType=='headquarter')
            {
                $request->session()->regenerate();
                
                return redirect()->intended('dashboards');
                

            }
            else if($officeType=="branch"){
            
                $branch = $user->office->id;
                return redirect()->intended('branchs/'.$branch. '/dashboards');
                dd('Authentication failed.You dont have permissions.');
            }   
        }
        else
        {
            dd('user is not registered');
        }


      
       

    }
}

