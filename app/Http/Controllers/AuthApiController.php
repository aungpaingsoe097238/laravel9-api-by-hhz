<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        if(Auth::attempt($request->only(['email','password']))){
            $data = Auth::user();
            $data['token']  = Auth::user()->createToken("phone")->plainTextToken;
            return json($data,'success',200);
        }
        return json([],'failed to create user',400);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if(Auth::attempt($request->only(['email','password']))){
            $data = Auth::user();
            $data['token']  = Auth::user()->createToken("phone")->plainTextToken;
            return json($data,'success',200);
        }
        return json([],'user not found',404);
    }

    public function logout(){
        Auth::user()->currentAccessToken()->delete();
        return json([],'success',200);
    }

    public function tokens(){
        return Auth::user()->tokens;
    }
}
