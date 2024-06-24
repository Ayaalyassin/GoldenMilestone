<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use TCG\Voyager\Models\Permission;
use App\Traits\GeneralTrait;

class AdminActionController extends Controller
{
    use GeneralTrait;

    public function addRoleU(Request $request)
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
        return response()->json("success");

    }

    public function addpermissionc(Request $request)
    {
        $permission=Permission::create([
            'key'=>$request->permission,
            'table_name'=>$request->permission
        ]);
        //return response()->json("success");
        return response()->json($permission);
    }



    /*public function addPermission(Request $request)
    {
        //setPermissionR($request);

        $permission=$request->permission;
        $role=$request->role;
        //$role_id=Role::where('name','=',$role)->select('id');
        //$permission=Permission::where('key','=',$permission)->get();

        $rolee = Role::firstOrNew(['name' => $role]);
        //$permissionn=Permission::firstOrNew(['key','=',$permission]);

        $permissionn=Permission::where('key','=',$permission)->get();
        if(is_null($permissionn))
        {
            $permissionnn=Permission::create(['key'=>$permissionn]);
            //return response()->json($permissionnn);
            return response()->json("notfound");
        }
        /*else{
            return response()->json("exist");
        }*/

        //return response()->json($permissionnn);
        //$role_user = Role::where('name', '=',$role)->firstOrFail();

            //$permissions1 = Permission::where("key","read_answers");


            /*$rolee->permissions()->sync(
                $permissionn->pluck('id')->all()
            );
        //$user->role_id=$role_id;
        //$user->save();

        //return response()->json("success");

        return response()->json("success");
    }*/



    /*public function addPermission(Request $request)
    {
        setPermissionR($request);
        //return $this->returnSuccessMessage("successfully");
        return response()->json("success");
    }*/

    public function addRolee(Request $request)
    {
          addRole($request);
          //return $this->returnSuccessMessage("successfully");
          return response()->json("success");

    }

    /*function setPermissionR(Request $request)
{
    $role=Role::where('name','=',$request->role)->get();
    //return $role;
    if(is_null($role))
    {
         $rolee = Role::Create(['name' => $request->role,
         'display_name' => $request->role]);


         return $rolee;
         $role=$rolee;

         $permission= Permission::firstOrCreate([
              'key'        => $request->permission,
             'table_name' => $request->permission,
         ]);
         return $permission;

        /*if(!$role->permissions()->where('permission_id',$permission->id)->first()){
            $role->permissions()->save( $permission );
        }*/


        /*$role_id=$role->id;
        $permission_id=$permission->id;

        DB::table('permission_role')->create([
            'role_id'=>$role_id,
            'permission_id'=>$permission_id
        ]);


    }
    else{
        $role_id=DB::table('roles')->where('name' ,'=',$role)
        ->value('id');
        //->select('id');
        return $role_id;
        $permission= Permission::firstOrCreate([
            'key'        => $request->permission,
            'table_name' => $request->permission,
        ]);

        /*if(!$role->permissions()->where('permission_id',$permission->id)->first()){
            $role->permissions()->save( $permission );
        }*/

        /*$role_id=$role->id;
        $permission_id=$permission->id;

        DB::table('permission_role')->create([
            'role_id'=>$role_id,
            'permission_id'=>$permission_id
        ]);

    }
    return response()->json("success");
}*/


public function setPermissionR(Request $request){

    /*$true=Role::where('name','=',$request->role)->get();
    if($true){
        $permission= Permission::firstOrCreate([
            'key'        => $request->permission,
            'table_name' => $request->permission,
        ]);

        if(!$true->permissions()->where('permission_id',$permission->id)->first()){
            //$true->permissions()->save( $permission );
            $true->permissions()->sync(
                $permission->pluck('id')->all()
            );
        }
    }*/



    $role = Role::firstOrCreate(['name' => $request->role,
    'display_name' => $request->role]);


    $permission= Permission::firstOrCreate([
        'key'        => $request->permission,
        'table_name' => $request->permission,
    ]);

    if(!$role->permissions()->where('permission_id',$permission->id)->first()){
        $role->permissions()->save( $permission );
    }

return $this->returnSuccessMessage("successfully");

}






    /*function setRole(Request $request)
    {
         //$role_id=Role::where('name','=',$role)->select('id');
        $email=$request->email;
        $role=$request->role;
        //$rolee=Role::where('name' ,'=',$role)->select('id');;
        $role_id=DB::table('roles')->where('name' ,'=',$role)
        //->select('id')->first();
        ->value('id');

        //$role_id=$rolee->id;
        //$user=User::where('email','=',$email)->get();

        User::where('email',$email)->update(['role_id'=>$role_id]);
        //return response()->json($role_id);

        //$user->role_id=$role_id;
        //$user->save();
        return response()->json("success");
    }*/


    public function index()
    {

        $posts=Post::with('images')->get();
        if(count($posts)<0)
        {
            return $this->returnError("404", "posts not found!");
        }

        return $this->returnData("posts", $posts);
    }




    /*public function store(Request $request)
    {
        $input= $request->all();
        $rules =[
            'description'=>'required',
        ];
        $validator=validator($input,$rules);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(),400);
        }

        $user = Auth::guard('api')->user();
        $input['user_id']=$user->id;
        $post = Post::create($input);

        if($request->has('images')){
            //foreach($request->file('images') as $image){
                $image=$request->images;
                //$file_extension = $image->extension();
                $file_extension = $image->getClientOriginalExtension();
                $file_name = time() . '.' . $file_extension;
                $image->move(public_path('images/products'), $file_name);
                Image::create([
                    'post_id'=>$post->id,
                    'image'=>$file_name
                ]);

            //}
        }

        return response()->json([
            'Post' => $post,

            'message' => 'Successfully added',
        ],201);
    }*/





    public function store(Request $request)
    {


        $validator=Validator::make($request->all(),[
            'description'=>['nullable','string'],
            //'images'=>['image','nullable']
            //,'mimes:jpeg,png,bmp,jpg,gif,svg']

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(),400);
        }

        $input= $request->all();

        $user = Auth::guard('api')->user();
        $input['user_id']=$user->id;
        $post = Post::create($input);
        $post_id=$post->id;
        if($request->has('images')){
            foreach($request->file('images') as $image){
                $file_name = time() . '.' . $image->getClientOriginalExtension();
                $path='images/' . $file_name;
                $image->move(public_path('images'), $file_name);
                Image::create([
                    'poste_id'=>$post_id,
                    'image_path'=>$path
                ]);
            }
        }
        $post->images=$post->images()->get();

        return response()->json([
            'Post' => $post,
            'message' => 'Successfully added',
        ],201);
    }






    public function show($id)
    {

        $post=Post::where('id','=',$id)->with('images')->first();

        if ($post)
            return $this->returnData("post", $post);
        else
            return $this->returnError("404", "There is no post with id:" . $id . " not found!");
    }





    public function update(Request $request,$id)
    {
        $question = Post::find($id);
        if ($question) {
            $question->update($request->all());
            return $this->returnSuccessMessage("update successfully");
        } else
            return $this->returnError("404", "There is no post with id:" . $id . " not found!");
    }




    public function delete($id){
        $post = post::find($id);
        if ($post) {
            $post->delete();
            return $this->returnSuccessMessage("delete successfully");
        } else
            return $this->returnError("404", "There is no post with id:" . $id . " not found!");
    }



    public function addstudent(Request $request)
    {
        $validator=Validator::make($request->all(),[

            'name'=>'required|string',
            //'email'=>'required|string|email|unique:users',
            'phone_number'=>['required','regex:/^(?:\+88|09)?(?:\d{10}|\d{13})$/'],
            'password' => 'required|min:8|max:32',
            'role'=>'string'

        ]);


        if($validator->fails())
        {
            return response()->json($validator->errors()->all());
        }

        try {
            /*$role = Role::where('name', '=',$request->role)->firstOrFail();
            User::create([
                'name'           => $request->name,
                //'email'          => $request->email,
                'password'       => bcrypt($request->password),
                'remember_token' => Str::random(60),
                'role_id'        => $role->id,
            ]);*/



            $phone_number=$request->phone_number;
            $role=$request->role;
            $role_id=DB::table('roles')->where('name' ,'=',$role)
            ->value('id');
            User::where('phone_number',$phone_number)->update(['role_id'=>$role_id]);

            return $this->returnSuccessMessage('Registering successfully');

        } catch (\Exception $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }


}

