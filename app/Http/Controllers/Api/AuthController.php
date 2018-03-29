<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use App\Http\Requests\RegisterRequest;
use JWTAuthException;
use Illuminate\Support\Facades\Request;
use Tymon\JWTAuth\JWTAuth;
class AuthController extends Controller
{
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function register(RegisterRequest $request)
    {
        $user = $this->user->create([
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'role'=>$request->get('role'),
            'password' => bcrypt($request->get('password'))
        ]);
        return response()->json(['status'=>true,'message'=>'User created successfully','data'=>$user]);
    }
    public function getAuthUser(Request $request){
        $user = JWTAuth::toUser($request->token);
        return response()->json(['result' => $user]);
    }
}
