<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\UserBlock;

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
        $ip = $_SERVER['REMOTE_ADDR'];

        $check = UserBlock::where('ip', '=', $ip)->first();

        if(isset($check)) {

            return response()->json([

                'status'    => true,
                'message'   => 'Sorry Your Account Was Block From The App',
                'data'      => []
    
            ], 200);

        } else {

            $user = User::create([

                'name'      => $name,
                'email'     => $email,
                'password'  => $password,
                'ip'        => $ip

            ]);


            $user->assignRole('user');


            return response()->json([

                'status'    => true,
                'message'   => 'new Account',
                'data'      => $user->createToken($email)->plainTextToken

            ], 200);

        }

    } // End Method



    public function login(Request $request) {

        if($request->isMethod('post')) { 

            $data = $request->validate([

                'email'     => 'required|email',
                'password'  => 'required'
    
            ]);


            $email = strip_tags($data['email']);
            $password = strip_tags($data['password']);

            $user = User::where('email', $email)->first();

            if(isset($user)) {

                $check = Hash::check($password, $user->password);

                if($check == true) { 

                    $ip = $_SERVER['REMOTE_ADDR'];

                    $user->ip = $ip;
                    $user->save();

                    return response()->json([

                        'status'    => true,
                        'message'   => 'Login Page',
                        'data'      => $user->createToken($email)->plainTextToken
        
                    ], 200);

                } else {

                    return response()->json([

                        'status'    => false,
                        'message'   => 'Password Not Correct',
                        'data'      => null
        
                    ], 200);

                }
             

            } else {

                return response()->json([

                    'status'    => false,
                    'message'   => 'The Email Not Found',
                    'data'      => null
    
                ], 200);


            }
         

        } else {

            return response()->json([

                'status'    => false,
                'message'   => 'This Page Not Found',
                'data'      =>  null

            ], 404);

        }

    } // End Method


    public function logout() {

        $user = auth('sanctum')->user();

        $user->tokens()->delete();

        return response()->json([

            'status'    => true,
            'message'   => 'You are Logout Successfully',
            'data'      =>  null

        ], 200);

    } // End Method
}
