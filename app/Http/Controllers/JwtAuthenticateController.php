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
             // get Auth user from token
        public function getAuthUser(Request $request){
            //$user_find=User::find($id);
            $user = JWTAuth::toUser($request->token);
            return response()->json(['result' => $user]);
        }
        public function attachPermission(Request $request){
            $role = Role::where('name', '=', $request->input('role'))->first();
            $permission = Permission::where('name', '=', $request->input('name'))->first();
            $role->attachPermission($permission);
            return response()->json("created");
        }
}
