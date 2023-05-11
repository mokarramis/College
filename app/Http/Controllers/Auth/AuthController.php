<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function register (Request $request) 
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password) 
        ]);

        $token = $user->createToken('access token')->accessToken;

        return response()->json(['token' => $token], 200);
    }

    public function login (Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('access token')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return 'went wrong';
        }
    }

    public function logout (Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json('logged out', 200);
    }
}
