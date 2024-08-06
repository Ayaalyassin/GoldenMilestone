<?php


namespace App\Services;

use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;
use TCG\Voyager\Models\Role;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService
{
    use GeneralTrait;

    protected $userService;

    public function __construc(UserService $userService)
    {
        $this->userService=$userService;
    }

    public function register($request)
    {
        try {
            $role = Role::where('name', 'user')->firstOrFail();
            User::create([
                'name'           => $request->name,
                'phone_number'   => $request->phone_number,
                'email'          => $request->email,
                'password'       => bcrypt($request->password),
                'remember_token' => Str::random(60),
                'role_id'        => $role->id,
            ]);

        } catch (\Exception $ex) {
            throw new HttpResponseException($this->returnError($ex->getCode(), $ex->getMessage()));
        }

    }



    public function login($request)
    {
        $credentials = ['phone_number'=>$request->phone_number
            , 'password'=>$request->password
        ];

        $token = JWTAuth::attempt($credentials);
        if (! $token) {
            throw new HttpResponseException($this->returnError('E001', 'Unauthorized'));
        }

        $user =auth()->user();
        $user->token = $token;

        return $user;
    }


    public function me()
    {
        return auth()->user();
    }


    public function logout($request)
    {
        $token = $request->bearerToken();
        if ($token) {
            try {

                JWTAuth::setToken($token)->invalidate(); //logout
            } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                throw new HttpResponseException($this->returnError('', 'some thing went wrongs'));
            }
        } else {
            throw new HttpResponseException($this->returnError('', 'some thing went wrongs'));
        }
    }


    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }


    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }



    public function post_profile($request)
    {
        $user=auth()->user();

        $image=$request->file('image');
        $file_name = time() . '.' . $image->getClientOriginalExtension();
        $path='profiles/' . $file_name;
        $image->move(public_path('profiles'), $file_name);

        User::where('id','=',$user->id)->update(['image_path'=>$path]);
    }

}
