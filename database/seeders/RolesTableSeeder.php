<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $role = Role::firstOrNew(['name' => 'admin']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => __('voyager::seeders.roles.admin'),
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'user']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => __('voyager::seeders.roles.user'),
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'student']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => __('voyager::seeders.roles.student'),
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'visitor']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => __('voyager::seeders.roles.visitor'),
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'A1']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => __('voyager::seeders.roles.A1'),
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'A2']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => __('voyager::seeders.roles.A2'),
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'A3']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => __('voyager::seeders.roles.A3'),
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'B1']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => __('voyager::seeders.roles.B1'),
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'B2']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => __('voyager::seeders.roles.B2'),
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'B3']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => __('voyager::seeders.roles.B3'),
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'C1']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => __('voyager::seeders.roles.C1'),
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'C2']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => __('voyager::seeders.roles.C2'),
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'C3']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => __('voyager::seeders.roles.C3'),
            ])->save();
        }





    }
}
