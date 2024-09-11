<?php


namespace App\Repositories;


use App\Models\User;
use Illuminate\Support\Str;

class UserRepository
{
    public function createUser($request,$role)
    {
        User::create([
            'name'           => $request->name,
            'phone_number'   => $request->phone_number,
            'email'          => $request->email,
            'password'       => bcrypt($request->password),
            'remember_token' => Str::random(60),
            'role_id'        => $role->id,
        ]);

    }

}
