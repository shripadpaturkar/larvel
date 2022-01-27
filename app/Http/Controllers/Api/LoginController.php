<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);


        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password))
        {
            return response()->json([
                'success' => 0,
                'message' => "incorrect"
            ], 401);
        }
        $token = $user->createToken('token')->plainTextToken;
        $token = explode('|', $token);
        return response()->json(['token'=>$token[1], 'id'=>$user->id, 'name'=>$user->name, 'email'=>$user->email]);

    }

}
