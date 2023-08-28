<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AthenticateController extends Controller
{

    public function register(Request $request){

        //Validate fields
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        //Create user
        $user =  User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        // Generate token
        $token = JWTAuth::fromUser($user);
        return response()->json(compact('token'));
    }
    
    public function login(Request $request)
    {
        $creds = $request->only(['email', 'password']);

        // Authenticate user
        if(!$token = auth()->attempt($creds)){
            return response()->json(['error' => 'Invalid email / password'], 401);
        };

        return response()->json(['token' => $token]);
    }

    public function refresh()
    {
        // Refresh token 
        try{

            $newToken = auth()->refresh();

        } catch(\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        } catch(\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json(['token' => $newToken]);
    
    }
}
