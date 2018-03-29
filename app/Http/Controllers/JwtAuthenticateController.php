<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Log;
use App\Http\Requests\RoleRequest;
use App\Http\Requests\PermissionRequest;
class JwtAuthenticateController extends Controller
{
    public function index()
    {
        return response()->json(['auth'=>Auth::user(), 'users'=>User::all()]);
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');
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
        return response()->json(compact('token'));
    }
        public function createRole(RoleRequest $request)
        {
            $role = new Role();
            $role->name = $request->input('name');
            if(($role->name == "admin")|| ($role->name == "user")) {
                $role->save();
            }
            else{
                "try to create valid role";
            }
            return response()->json("created");
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
