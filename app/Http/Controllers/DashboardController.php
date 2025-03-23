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
use App\Models\Product;
use App\Models\Orders;
use Illuminate\Support\Facades\DB;
use App\Models\UserBlock;
use Carbon\Carbon;
use App\Models\Support;
use Illuminate\Support\Facades\Session;

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
        $productInStock = Product::where('avalibale', '=', 1)->count('id');
        $productOutStock = Product::where('avalibale', '=', 0)->count('id');

        $limitedStock = Product::where('quantity', '<', 10)->latest()->paginate(10);
        $sales = Orders::where('status', '=', true)->sum('price');

        $salesPro = DB::table('orders')
        ->join('products', 'orders.product_id', 'products.id')
        ->select('orders.price', 'orders.quantity', 'products.pro_name', 'orders.created_at')
        ->latest()
        ->paginate(10);

        return view('dashboard', compact('Brand', 'productInStock', 'productOutStock', 'limitedStock', 'sales', 'salesPro'));

    } // End Method


    public function users_view() {


        $users = User::role('user')->latest()->paginate(10);
        return view('dashboard.users.index', compact('users'));
      

    } // End Method


    public function users_block($id) {

        $user = User::where('id', '=', $id)->first();

        $message = Support::where('sender', '=', $id)->get();

        foreach($message as $val) {

            Support::where('message_no', '=', $val->message_no)->delete();

        }

        UserBlock::insert([
            'ip'            => $user->ip,
            'created_at'    => Carbon::now()
        ]);

        User::where('id', '=', $id)->delete();

        return redirect()->back()->with('msg', 'User Blocked Successfully');

    } // End Method


    public function admin_profile() {

        $user = User::where('id', '=', Auth::user()->id)->first();
        return view('dashboard.profile.index', compact('user'));
        
    } // End Method


    public function admin_profile_update(Request $request) {

        if($request->isMethod('post')) {

            $name = strip_tags($request->name);
            $email = strip_tags($request->email);
            
            $user = User::where('id', '=', Auth::user()->id)->first();

            $user->name = $name;
            $user->email = $email;

            if($request->password != null) {

                $user->password = Hash::make($request->password);

            }


            if($request->img != null) {

                if($user->img != '') {

                    unlink($user->img);

                }

                $img = $request->file('img');
                $gen = hexdec(uniqid());
                $ex  = strtolower($img->getClientOriginalExtension());
                $name = $gen . '.' . $ex;
                $location = 'images/profile/';
                $source = $location. $name;
                $img->move($location, $name);

                $user->img = $source;

            }
            
            $user->save();

            if($user == true) {

                return redirect()->back()->with('msg', 'Profile Updated Successfully');
            }
           

        } else {

            return redirect()->back();
        }

    } // End Method

    public function admin_logout() {

        Auth::logout();
        Session::flush();

        return redirect()->route('login');

    } // End Method
}
