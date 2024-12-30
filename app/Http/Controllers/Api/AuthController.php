<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    public function register(Request $request) {

        $data = $request->validate([

            'name'      => 'required|max:255',
            'email'     => 'required|email|unique:users',
            'password'  => 'required'

        ]);


        $name = strip_tags($data['name']);
        $email = strip_tags($data['email']);
        $password = Hash::make($data['password']);

        $user = User::create([

            'name'=> $name,
            'email'=> $email,
            'password'=> $password

        ]);


        $user->assignRole('user');


        return response()->json([

            'status'    => true,
            'message'   => 'new Account',
            'data'      => $user->createToken($email)->plainTextToken

        ]);

    } // End Method
}
