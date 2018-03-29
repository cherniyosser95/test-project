<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use JWTException;
use Log;
use App\Http\Requests\RoleRequest;
use App\Http\Requests\PermissionRequest;
class JwtAuthenticateController extends Controller
{
    //get All User
    public function index()
    {
        return response()->json(['auth'=>Auth::user(), 'users'=>User::all()]);
    }
    //Login User (s'il y'a pas d'erreur au niveau de credentials va retourner le token)
        public function authenticate(Request $request)
        {
            $credentials = $request->only('username', 'password');
            $token=null;
          try {
                // verify the credentials and create a token for the user
                if (! $token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'invalid_credentials'], 401);
                }
            } catch (JWTException $e) {
                // something went wrong
                return response()->json(['error' => 'could_not_create_token'], 500);
            }

            // if no errors are encountered we can return a JWT
            return response()->json(['auth->id'=>Auth::user()->id,'token'=>$token]);
        }
        // get Auth user from token passé en paramétre
        public function getAuthUser(Request $request){
            //$user_find=User::find($id);
            $user = JWTAuth::toUser($request->token);
            return response()->json(['result' => $user]);
        }
    // create role for user
        public function createRole(RoleRequest $request)
        {
            $role = new Role();
            $role->name = $request->input('name');
            // test sur le role name, doit etre si admin ou bien user pour ne pas risqué d'entrer un nom quelconque
            if(($role->name == "admin")|| ($role->name == "user")) {
                $role->save();
            }
            else{
                "try to create valid role";
            }
            return response()->json("created");
        }
        //edit Role
        public function EditRole(RoleRequest $request,$id)
        {
            $role =Role::find($id);
            $role->name = $request->input('name');
            // test sur le role name, doit etre si admin ou bien user pour ne pas risqué d'entrer un nom quelconque
            if(($role->name == "admin")|| ($role->name == "user")) {
                $role->update();
            }
            else{
                "try to update valid role";
            }
            return response()->json("updated");
        }
        public function DeleteRole(RoleRequest $request,$id)
        {
            $role =Role::find($id);
            $role->delete();
            return response()->json("deleted");
        }
        public function GetRoles()
        {
            $roles =Role::all();
            return response()->json(compact('roles'));
        }

        public function createPermission(PermissionRequest $request){
            $viewUsers = new Permission();
            $viewUsers->name = $request->input('name');
            $viewUsers->save();

            return response()->json("created");
        }
        public function assignRole(Request $request){
            $user = User::where('email', '=', $request->input('email'))->first();
            $role = Role::where('name', '=', $request->input('role'))->first();
            //$user->attachRole($request->input('role'));
            $user->roles()->attach($role->id);

            return response()->json("created");
        }

        public function attachPermission(Request $request){
            $role = Role::where('name', '=', $request->input('role'))->first();
            $permission = Permission::where('name', '=', $request->input('name'))->first();
            $role->attachPermission($permission);
            return response()->json("created");
        }
}
