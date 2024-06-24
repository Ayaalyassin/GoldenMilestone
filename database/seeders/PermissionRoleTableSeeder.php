<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Role;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'admin')->firstOrFail();

        $permissions = Permission::all();

        $role->permissions()->sync(
            $permissions->pluck('id')->all()
        );


        /*$role_user = Role::where('name', 'user')->firstOrFail();

        $permissions1 = Permission::where("key","read_answers");
        $permissions2 = Permission::where("key","read_questions");

        $role_user->permissions()->sync(
            $permissions1->pluck('id')->all()
        );
        $role_user->permissions()->sync(
            $permissions2->pluck('id')->all()
        );*/




        /*$role_student = Role::where('name', 'student')->firstOrFail();

        $permissions1 = Permission::where("key","read_answers");
        $permissions2 = Permission::where("key","read_questions");
        $permissions3 = Permission::where("key","edit_answers");
        $permissions4 = Permission::where("key","add_orders");

        $role_student->permissions()->sync(
            $permissions1->pluck('id')->all()
        );
        $role_student->permissions()->sync(
            $permissions2->pluck('id')->all()
        );

        $role_student->permissions()->sync(
            $permissions3->pluck('id')->all()
        );

        $role_student->permissions()->sync(
            $permissions4->pluck('id')->all()
        );*/


        /*$role_visitor = Role::where('name', 'visitor')->firstOrFail();

        $permissions1 = Permission::create(['key'=>"gh",
          'table_name'=>"gh"
        ]);
        $role_visitor->permissions()->sync(
            $permissions1->pluck('id')->all()
        );*/


        $role_user = Role::where('name', 'student')->firstOrFail();
        $permissionA1=Permission::where('key','=',"A1")->get();

        $role_user->permissions()->syncWithoutDetaching(
            $permissionA1->pluck('id')->all()
        );

        $permissionA2=Permission::where('key','=',"A2")->get();

        $role_user->permissions()->syncWithoutDetaching(
            $permissionA2->pluck('id')->all()
        );

        $permissionA3=Permission::where('key','=',"A3")->get();

        $role_user->permissions()->syncWithoutDetaching(
            $permissionA3->pluck('id')->all()
        );

        $permissionB1=Permission::where('key','=',"B1")->get();

        $role_user->permissions()->syncWithoutDetaching(
            $permissionB1->pluck('id')->all()
        );

        $permissionB2=Permission::where('key','=',"B2")->get();

        $role_user->permissions()->syncWithoutDetaching(
            $permissionB2->pluck('id')->all()
        );

        $permissionB3=Permission::where('key','=',"B3")->get();

        $role_user->permissions()->syncWithoutDetaching(
            $permissionB3->pluck('id')->all()
        );

        $permissionC1=Permission::where('key','=',"C1")->get();

        $role_user->permissions()->syncWithoutDetaching(
            $permissionC1->pluck('id')->all()
        );

        $permissionC2=Permission::where('key','=',"C2")->get();

        $role_user->permissions()->syncWithoutDetaching(
            $permissionC2->pluck('id')->all()
        );

        $permissionC3=Permission::where('key','=',"C3")->get();

        $role_user->permissions()->syncWithoutDetaching(
            $permissionC3->pluck('id')->all()
        );





    }
}
