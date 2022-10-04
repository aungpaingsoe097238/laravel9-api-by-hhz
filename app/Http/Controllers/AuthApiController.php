<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use TheSeer\Tokenizer\Token;
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
            $token = Auth::user()->createToken("phone")->plainTextToken;
            return response()->json($token);
        }
        return response()->json([],403);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if(Auth::attempt($request->only(['email','password']))){
            $token = Auth::user()->createToken("phone")->plainTextToken;
            return response()->json($token);
        }
        return response()->json(['User not found.'],403);
    }

    public function logout(){
        Auth::user()->currentAccessToken()->delete();
        return response()->json([],204);
    }

    public function tokens(){
        return Auth::user()->tokens;
    }
}
