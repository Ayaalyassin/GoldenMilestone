<?php

use TCG\Voyager\Models\Role;
use App\Models\User;
use TCG\Voyager\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


function setRoleU(Request $request)
{
        $phone_number=$request->phone_number;
        $role=$request->role;
        $role_id=DB::table('roles')->where('name' ,'=',$role)
        ->value('id');
        if(is_null($role_id))
        {
               return response()->json("role not found");
        }
        User::where('phone_number',$phone_number)->update(['role_id'=>$role_id]);

        //return response()->json("success");
}

function setPermissionR(Request $request)
{
    $role=Role::where('name','=',$request->role,)->get();
    return $role;
    if($role){
    $role = Role::firstOrCreate(['name' => $request->role,
    'display_name' => $request->role]);
    }

    $permission= Permission::firstOrCreate([
        'key'        => $request->permission,
        'table_name' => $request->permission,
    ]);

    if(!$role->permissions()->where('permission_id',$permission->id)->first()){
        $role->permissions()->save( $permission );
    }

    //return response()->json("success");
}



function addRole(Request $request)
{
        $role=$request->role;
        Role::create([
            'name'=>$role,
             'display_name'=>$role
    ]);
}
