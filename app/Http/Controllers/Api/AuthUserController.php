<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use TCG\Voyager\Models\Role;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\PandingUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthUserController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */

    use GeneralTrait;

    public function register (AuthRequest $request)
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

            return $this->returnSuccessMessage('Registering successfully');

        } catch (\Exception $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }


    /*public function register (AuthRequest $request)
    {
        try {
            //$role = Role::where('name', 'user')->firstOrFail();
            PandingUser::create([
                'name'           => $request->name,
                'email'          => $request->email,
                'password'       => bcrypt($request->password),
                'remember_token' => Str::random(60),
                //'role_id'        => $role->id,
            ]);

            return $this->returnSuccessMessage('Registering successfully');

        } catch (\Exception $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }*/


    public function login(LoginRequest $request)
    {
        $credentials = ['phone_number'=>$request->phone_number
            , 'password'=>$request->password
                ];

        $token = JWTAuth::attempt($credentials);
        if (! $token) {
            return $this->returnError('E001', 'Unauthorized');
        }

        $user =auth()->user();
        $user->token = $token;
        //return token
        return $this->returnData('user', $user);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $token = $request->bearerToken();
        if ($token) {
            try {

                JWTAuth::setToken($token)->invalidate(); //logout
                return $this->returnSuccessMessage('Logged out successfully');
            } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                return $this->returnError('', 'some thing went wrongs');
            }
        } else {
            return $this->returnError('', 'some thing went wrongs');
        }
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }



    public function post_profile(Request $request)
    {
        $user=auth()->user();

        $validator=Validator::make($request->all(),[
            'image'=>'image'
            //,'mimes:jpeg,png,bmp,jpg,gif,svg']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(),400);
        }
        $image=$request->file('image');
        $file_name = time() . '.' . $image->getClientOriginalExtension();
        $path='profiles/' . $file_name;
        //return $path;
        $image->move(public_path('profiles'), $file_name);

        User::where('id','=',$user->id)->update(['image_path'=>$path]);
        return response()->json("save successfully");
    }
}
