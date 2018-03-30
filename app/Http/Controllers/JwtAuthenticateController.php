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
            return response()->json(['auth_user_id'=>Auth::user()->id,'token'=>$token]);
        }
             // get Auth user from token et id_user passed en parametre
        public function getAuthUser(Request $request){
            $user_find=User::find($request->id);
            $user = JWTAuth::toUser($request->token,$user_find->id);
            return response()->json(['result' => $user]);
        }

}
