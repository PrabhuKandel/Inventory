<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class BranchAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       
        $branchId = (int)$request->route('id');
        
   if(Auth::check() && (Auth::user()->hasRole('Super Admin')|| Auth::user()->hasRole('Headquarter Admin')|| Auth::user()->hasRole('Headquarter User')))
   {
    return $next($request);
   }
    
        //checking if auth user have access to requested branch
    
        if(!Auth::check()|| Auth::user()->office_id!=$branchId){

            abort(403,'You  do not have permission for this action');
        }
        return $next($request);
       
    }
}
