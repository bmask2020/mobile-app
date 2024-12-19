<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgetPassword;
use Illuminate\Support\Facades\Hash;
use App\Models\Brand;

class DashboardController extends Controller
{
    
    public function admin_login(Request $request) {

        if($request->isMethod('post')) {

            $validated = $request->validate([
                'email'     => 'required',
                'password'  => 'required',

            ], [

                'email.required'    => 'Plz Write Your Email',
                'password.required' => 'Plz Write Your Password'
            ]);


            $email      = $request->email;
            $password   = $request->password;

            $user = User::where('email', '=', $email)->first();

            if(isset($user) && $user->hasRole('admin')) {

                if (Auth::attempt(['email' => $email, 'password' => $password])) {

                    $request->session()->regenerate();
         
                    return redirect()->intended('dashboard');

                } else {

                    return redirect()->back()->with('msg', 'Password Not Correct');

                }

            } else {

                return redirect()->back()->with('msg', 'Can\'t Access To This Page');
            }
            

        } else {

            return redirect()->route('login');
        }

    } // End Method



    public function admin_forget_password(Request $request) {

        if($request->isMethod('post')) {

            $check = User::where('email', '=', $request->email)->first();

            if(isset($check) && $check->hasRole('admin')) {

                $data = Mail::to($check->email)->send(new ForgetPassword($check->id));

                return redirect()->back()->with('msg', 'Reset Password Link Sent To Your Mail');
                
            } else {


                return redirect()->back()->with('msg', 'Sorry Email Not Found');
            }
           

        } else {

            return redirect()->route('login');
        }
       

    } // End Method



    public function admin_reset_password($id) {

        return view('auth.reset-password', compact('id'));

    } // End Method


    public function admin_update_password(Request $request) {

        $validated = $request->validate([
            'password' => 'required',
            
        ]);

        $id         = $request->id;
        $password   = Hash::make($request->password);

        $user = User::where('id', '=', $id)->update([

            'password'  => $password
        ]);


       return redirect()->back()->with('msg', 'Your Password is Updated Success');
       
    } // End Method


    public function dashboard() {

        $Brand = Brand::count('id');
        return view('dashboard', compact('Brand'));

    } // End Method
}
