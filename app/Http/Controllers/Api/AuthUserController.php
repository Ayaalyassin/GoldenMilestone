<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ProfileRequest;
use App\Services\UserService;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;


class AuthUserController extends Controller
{

    use GeneralTrait;

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService=$userService;
    }

    public function register(AuthRequest $request)
    {
        $this->userService->register($request);
        return $this->returnSuccessMessage('Registering successfully');

    }



    public function login(LoginRequest $request)
    {
        $user=$this->userService->login($request);
        return $this->returnData('user', $user);
    }


    public function me()
    {
        $user=$this->userService->me();
        return response()->json($user);
    }


    public function logout(Request $request)
    {
        $this->userService->logout($request);
        return $this->returnSuccessMessage('Logged out successfully');

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



    public function post_profile(ProfileRequest $request)
    {
        $this->userService->post_profile($request);

        return response()->json("save successfully");
    }
}
