<?php

namespace App\Http\Middleware;
namespace App\Http\Middleware;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;

use Closure;


class PermissionMiddleWare
{
    Use GeneralTrait;

    public function handle($request, Closure $next, $permission)
    {

        try {

            if(!Auth::user()->hasPermission($permission)) {
                return $this->returnError("","USER DOES NOT HAVE THE RIGHT PERMISSIONS");
            }
            return $next($request);
        }catch (\Exception $e){
            return $this->returnError("","USER DOES NOT HAVE THE RIGHT PERMISSIONS");
        }
    }
}
