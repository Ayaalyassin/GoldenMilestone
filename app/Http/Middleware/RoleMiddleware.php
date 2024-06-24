<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use TCG\Voyager\Models\Role;

class RoleMiddleware
{
    Use GeneralTrait;
   
    
    public function handle(Request $request, Closure $next,$role)
    {
        try {

            $user=Auth::user();
            
          
        
            $roles = is_array($role)
            ? $role
            : explode('|', $role);

        foreach ($roles as $role) {
            $role_row = Role::where('name', $role)->first();
            if($user->role_id==$role_row->id)
                return $next($request);
        }

         
        }catch (\Exception $e){
            return $this->returnError("","USER DOES NOT HAVE THE RIGHT ROLES");
        }
        return $this->returnError("","USER DOES NOT HAVE THE RIGHT ROLES");
    }
}
