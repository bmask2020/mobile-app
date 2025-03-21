<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Favorite;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\PhoneVerify;
use App\Models\Orders;
use App\Events\LiveChat;
use App\Models\Support;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
   
    public function home() {

        $brand = Brand::all();
        $product = Product::where('avalibale', '=', 1)->get();

        return response()->json([
            'status'    => true,
            'message'   => 'App Home Page',
            'brand'     => $brand,
            'product'   => $product

        ], 200);

    } // End Method


    public function products_by_brand($brand) {

        $brands = Brand::where('id', '=', $brand)->first();

        $products = Product::where([

            ['avalibale', '=', 1],
            ['brand', '=', $brands->id]

        ])->get();

        return response()->json([
            'status'    => true,
            'message'   => 'Products By Brand Page',
            'brand'     => $brand,
           'products'   => $products

        ], 200);

    } // End Method


    public function products_view($id) {

        $data = Product::findOrFail($id);

        return response()->json([

            'status'    => true,
            'message'   => 'Product View',
            'product'   => $data

        ], 200);

    } // End Method


    public function filters($filter) {

        if($filter == 'low') {

            $data = Product::orderBy('price', 'asc')->get();

        } else if($filter == 'high') {

            $data = Product::orderBy('price', 'desc')->get();

        } else if($filter == 'new') {

            $data = Product::latest()->get();


        } else if($filter == 'old') {

            $data = Product::all();

        }

        return response()->json([

            'status'    => true,
            'message'   => 'Product Filters',
            'product'   => $data

        ], 200);


    } // End Method


    public function filters_by_brand($brand, $filter) { 

        $Brand = Brand::findorFail($brand);

        if($filter == 'low') {

            $data = Product::where('brand', '=', $brand)->orderBy('price', 'asc')->get();

        } else if($filter == 'high') {

            $data = Product::where('brand', '=', $brand)->orderBy('price', 'desc')->get();

        } else if($filter == 'new') {

            $data = Product::where('brand', '=', $brand)->latest()->get();

        } else if($filter == 'old') {

            $data = Product::where('brand', '=', $brand)->get();

        }

        return response()->json([

            'status'    => true,
            'message'   => 'Product Filters By Brand',
            'product'   => $data

        ], 200);

    } // End Method


    public function add_favorite($product_id) {

        $user = auth('sanctum')->user();

        $check = Favorite::where([

            ['user_id', '=', $user->id],
            ['product_id', '=', $product_id]

        ])->first();


        if(isset($check)) {

            return response()->json([

                'status'    => false,
                'message'   => 'You Added This Product Before',
                'product'   => null
    
            ], 200);

        } else {

            $data = new Favorite;
            $data->product_id = $product_id;
            $data->user_id = $user->id;
            $data->created_at = Carbon::now();
            $data->save();

            return response()->json([

                'status'    => true,
                'message'   => 'Product Added To Favorite Successfully',
                'product'   => $data
    
            ], 200);


        }
        

    } // End Method



    public function fetch_favorite() {

        $user = auth('sanctum')->user();

        $data = DB::table('favorites')
        ->where('user_id', '=', $user->id)
        ->join('products', 'favorites.product_id', 'products.id')
        ->select('products.*')
        ->get();

        return response()->json([

            'status'    => true,
            'message'   => 'User Favorite',
            'user'   => $data

        ], 200);

    } // End Method



    public function remove_favorite($id) {

        $user = auth('sanctum')->user();

        $data = Favorite::where([

            ['user_id', '=', $user->id],
            ['product_id', '=', $id]

        ])->delete();

        if($data == true) {

            return response()->json([

                'status'    => true,
                'message'   => 'Product Removed From Favorite Successfully',
            
    
            ], 200);

        } else {

            return response()->json([

                'status'    => true,
                'message'   => 'Some Thing Wrong Plz Try Again',
             
    
            ], 200);


        }
      

    } // End Method



    public function add_cart(Request $request) {

        if($request->isMethod('post')) {

            $data = $request->validate([

                'product'   => 'required',
                'price'     => 'required',
                'quantity'  => 'required'

            ]);


           
            $user       = auth('sanctum')->user();
            $product    = strip_tags($data['product']);
            $price      = strip_tags($data['price']);
            $quantity   = strip_tags($data['quantity']);

            $check = Cart::where([

                ['user_id', '=', $user->id],
                ['product', '=', $product]

            ])->first();

            if(isset($check)) {

                return response()->json([

                    'status'    => true,
                    'message'   => 'This Product Added To Cart Before',
                 
        
                ], 200);


            } else {


                $data = Cart::insert([

                    'user_id'       => $user->id,
                    'product'       => $product,
                    'price'         => $price,
                    'quantity'      => $quantity,
                    'created_at'    => Carbon::now()
    
                ]);


                return response()->json([

                    'status'    => true,
                    'message'   => 'The Product Add To Cart Successfully',
                 
        
                ], 200);
    

            }
          

        } else {

            return response()->json([

                'status'    => false,
                'message'   => 'This Page Not Found',
             
    
            ], 404);

        }

    } // End Method



    public function cart_fetch() {

        $user = auth('sanctum')->user();

        $data = DB::table('carts')
        ->where('user_id', '=', $user->id)
        ->join('products', 'carts.product', 'products.id')
        ->select('carts.id', 'carts.price', 'carts.quantity', 'carts.created_at', 'products.pro_name', 'products.img')
        ->latest()
        ->paginate(10);

        return response()->json([

            'status'    => true,
            'message'   => 'Fetch Cart All Products',
            'data'      => $data

        ], 200);

    } // End Method



    public function cart_remove($id) {

        $check = Cart::where('id','=', $id)->first();

        if(isset($check)) {

            $check->delete();

            return response()->json([

                'status'    => true,
                'message'   => 'Product Deleted From Cart Successfully',
    
            ], 200);

        } else {

            return response()->json([

                'status'    => false,
                'message'   => 'The Product Not Found in Your Cart',
    
            ], 200);

        }
    } // End Method


    public function cart_remove_all() {

        $user  = auth('sanctum')->user();

        $data = Cart::where('user_id', '=', $user->id)->delete();

        if($data > 0) {

            return response()->json([

                'status'    => true,
                'message'   => 'Products Deleted From Cart Successfully',
    
            ], 200);

        } else {

            return response()->json([

                'status'    => true,
                'message'   => 'There are not Found Products in Your Cart',
    
            ], 200);

        }
       

    } // End Method



    public function phone_verify(Request $request) {

        if($request->isMethod('post')) {

            $data = $request->validate([

                'phone'=> 'required|numeric',

            ]);

            $user  = auth('sanctum')->user();
            $phone = substr($data['phone'], 1);
            

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.authentica.sa/api/sdk/v1/sendOTP');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Accept: application/json',
                'X-Authorization: $2y$10$FtJC93GNzLOvDW5zbWn2eer.qVQURhK29wIzsQbc38J/fy1C4Q5L6',
                'Content-Type: application/json',
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n    \"phone\":\"+966$phone\",\n    \"method\":\"sms\",\n    \"sender_name\": \"\",\n    \"number_of_digits\": 4,\n    \"otp_format\": \"numeric\",\n    \"is_fallback_on\": 0 \n}");
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

            $response = curl_exec($ch);

            curl_close($ch);

            $res = json_decode($response, true);

            if($res["success"] == true) { 

                PhoneVerify::where('user_id', '=', $user->id)->delete();

                PhoneVerify::insert([

                    'user_id'   => $user->id,
                    'phone'     => $data['phone'],
                    'created_at'    => Carbon::now()
                ]);

               

                return response()->json([

                    'status'    => true,
                    'message'   => 'The OTP Sent To Your Phone Number',
            
                ], 200);
               
            } else {

                return response()->json([

                    'status'    => False,
                    'message'   => 'There is Wrong Plz Try Again',
        
                ], 200);
            }

            

        } else {

            return response()->json([

                'status'    => False,
                'message'   => 'This Page Not Found',
    
            ], 404);

        }

    } // End Method



    public function otp_verify(Request $request) {

        if($request->isMethod('post')) {

            $data = $request->validate([
                'otp' => 'required|numeric'
            ]);

            $user  = auth('sanctum')->user();
            $otp = $data['otp'];

            $userPhone = PhoneVerify::where('user_id', '=', $user->id)->first();

            $phone = $userPhone->phone;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.authentica.sa/api/sdk/v1/verifyOTP');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'X-Authorization: $2y$10$FtJC93GNzLOvDW5zbWn2eer.qVQURhK29wIzsQbc38J/fy1C4Q5L6',
                'Accept: application/json',
                'Content-Type: application/json',
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n    \"phone\":\"+966$phone\",\n    \"otp\":\"$otp\"\n}");
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

            $response = curl_exec($ch);

            curl_close($ch);

            $res = json_decode($response, true);


            if($res['status'] == true) {

                $userPhone->verify = true;
                $userPhone->save();

                return response()->json([

                    'status'    => true,
                    'message'   => "Thank You For Verify Your Phone",
        
                ], 200);


            } else {

                return response()->json([

                    'status'    => true,
                    'message'   => "There is Something Wrong Plz Try Again",
        
                ], 200);


            }



        } else {

            return response()->json([

                'status'    => False,
                'message'   => 'This Page Not Found',
    
            ], 404);
        }

    } // End Method


    public function create_orders() {

        $user  = auth('sanctum')->user();

        $Cart = Cart::where('user_id', '=', $user->id)->get();

        if(count($Cart) > 0) {


            foreach($Cart as  $val) {

                Orders::insert([
                    'user_id'       => $user->id,
                    'product_id'    => $val->product,
                    'quantity'      => $val->quantity,
                    'price'         => $val->price,
                ]);

            }


            $orders_price = Orders::where([
                ['user_id', '=', $user->id],
                ['status', '=', false]
                
            ])->sum('price');

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://secure.telr.com/gateway/order.json');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'accept: application/json',
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "\n{\n  \"method\": \"create\",\n  \"store\": 0000,\n  \"authkey\": \"0000\",\n  \"framed\": 1,\n  \"order\": {\n    \"cartid\": \"$user->id\",\n    \"test\": \"1\",\n    \"amount\": \"$orders_price\",\n    \"currency\": \"SAR\",\n    \"description\": \"My purchase\"\n  },\n  \"return\": {\n    \"authorised\": \"http://127.0.0.1:8000/api/authorised/$user->id\",\n    \"declined\": \"http://127.0.0.1:8000/api/declined/$user->id\",\n    \"cancelled\": \"http://127.0.0.1:8000/api/cancelled/$user->id\"\n  }\n}\n");

            $response = curl_exec($ch);

            curl_close($ch);

            $result = json_decode($response, true);
            
            $url = $result['order']['url'];
            $ref = $result['order']['ref'];

            Orders::where([
                ['user_id', '=', $user->id],
                ['status', '=', false]

            ])->update([
                'ref'   => $ref
            ]);

           
            Cart::where('user_id', '=', $user->id)->delete();

            return response()->json([

                'status'            => true,
                'order_url'         => $url,
    
            ], 200);

        } else {

            return response()->json([

                'status'    => true,
                'message'   => 'You Not Have Any Products in Your Cart',
    
            ], 200);

        }
       
    } // End Method


    public function authorised($id) {

        $orders = Orders::where([
            ['user_id', '=', $id],
        ])->latest()->first();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://secure.telr.com/gateway/order.json');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'accept: application/json',
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "\n{\n  \"method\": \"check\",\n  \"store\": 0000,\n  \"authkey\": \"000000\",\n  \"order\": {\n    \"ref\": \"$orders->ref\"\n  }\n}\n");

        $response = curl_exec($ch);

        curl_close($ch);

        $result = json_decode($response, true);

        $stauts = $result['order']['status']['text'];

        if($stauts == 'Paid') {

            Orders::where([

                ['user_id', '=', $id],
                ['status', '=', false]

            ])->update([
                'status'    => true
            ]);

            $order = Orders::where([
                ['user_id', '=', $id],
                ['ref', '=', $orders->ref]
            ])->get();


            foreach($order as $val) {

               $pro =  Product::where('id', '=', $val->product_id)->first();

               $pro->quantity = $pro->quantity - $val->quantity;
               $pro->save();

            }

            return response()->json([

                'status'   => true,
                'message'  => 'Thank You, Your Payment Successfully',
    
            ], 200);

        } else {

            return response()->json([

                'status'   => false,
                'message'  => 'Your Payment Not Complete',
    
            ], 200);

        }
      

    } // End Method


    public function declined($id) {

        Orders::where([

            ['user_id', '=', $id],
            ['status', '=', false]

        ])->delete();

        return response()->json([

            'status'   => false,
            'message'  => 'Your Payment Not Complete',

        ], 200);
        
    } // End Method


    public function cancelled($id) {

        Orders::where([

            ['user_id', '=', $id],
            ['status', '=', false]

        ])->delete();

        return response()->json([

            'status'   => false,
            'message'  => 'Your Payment Not Complete',

        ], 200);
        
    } // End Method


    public function orders_fetch() {

        $user  = auth('sanctum')->user();

        $data = DB::table('orders')
        ->where([
            ['user_id', '=', $user->id],
            ['status', '=', 1]
        ])
        ->join('products', 'orders.product_id', 'products.id')
        ->select('orders.quantity', 'orders.price', 'products.pro_name','products.img', 'orders.created_at')
        ->latest()
        ->paginate(10);

        return response()->json([

            'status'    => true,
            'orders'    => $data,

        ], 200);

    } // End Method



    public function live_chat(Request $request) {

        if($request->isMethod('post')) { 

            $headers = getallheaders();
            $token = substr($headers['Authorization'], 7);

            $message = strip_tags($request->message);

            $pusher = new \Pusher\Pusher(
                "0151b92565c624fbd709",
                "7ace1df5295c21bebef4",
                "1141262",
                array('cluster' => 'eu')
              );
              
            $id     = auth('sanctum')->user()->id;
            $name   = auth('sanctum')->user()->name;
            $time   = Carbon::now()->diffForHumans();
            $pusher->trigger('live-chat', 'my-event', ['message' => $message, 'id' => $id, 'name' => $name, 'time' => $time]);

            if($pusher == true) {

                $user  = auth('sanctum')->user();

                $check = Support::where('sender', '=', $user->id)->first();

                if(isset($check)) {

                    $Support = new Support;
                    $Support->message_no    = $check->message_no;
                    $Support->sender        = $user->id;
                    $Support->message       = $message;
                    $Support->token         = $token;
                    $Support->created_at    = Carbon::now();
                    $Support->save();

                } else {

                    $randNo = rand(1000, 1000000);

                    $Support = new Support;
                    $Support->message_no    = $randNo;
                    $Support->sender        = $user->id;
                    $Support->message       = $message;
                    $Support->token         = $token;
                    $Support->created_at    = Carbon::now();
                    $Support->save();
                    
                }
               

                return response()->json([

                    'status'    => true,
                    'message'   => "Your Message Sent Successfully",
        
                ], 200);

            }

        } else {

            return response()->json([

                'status'    => false,
                'message'   => "This Page Not Found",
    
            ], 404);
        }

    } // End Method


    public function live_chat_replay(Request $request) {

        $pusher = new \Pusher\Pusher(
            "0151b92565c624fbd709",
            "7ace1df5295c21bebef4",
            "1141262",
            array('cluster' => 'eu')
          );

        $sender = $request->sender;
        $name   = $request->name;
        $message = strip_tags($request->message);

        $first = Support::where([
            ['message_no', '=', $request->message_no],
            ['sender', '!=', '1']
        ])->first();

       
        $pusher->trigger('live-chat', 'my-event', ['message' => $message, 'token' => $first->token, 'name' => $name]);

      
        $Support = Support::insert([
            'message_no'    => $request->message_no,
            'sender'        => $sender,
            'message'       => $message,
            'token'         => $first->token,
            'created_at'    => Carbon::now()
        ]);

        return response()->json($Support);

    } // End Method



    public function profile() {

        $user  = auth('sanctum')->user();

        $data = User::where('id', '=', $user->id)
        ->select(['id', 'name', 'email'])
        ->first();

        return response()->json([

            'status'    => true,
            'message'   => "Profile Data",
            'data'      => $data

        ], 200);

    } // End Method


    public function profile_update(Request $request) {

        if($request->isMethod('post')) {

            $user       = auth('sanctum')->user();

            $data       = User::where('id', '=', $user->id)->first();

            $name       = strip_tags($request->name);
            $email      = strip_tags($request->email);
            $password   = $request->password;
            $img        = $request->file('img');

          
            if($name != '') {

                $data->name = $name;
            }

            if($email != '') {

                $data->email = $email;

            }

            if($password != '') {

                $data->password = Hash::make($password);
            }


            if(isset($img)) {

                if($data->img != '') {

                    unlink($data->img);
                }

                $gen        = hexdec(uniqid());
                $exe        = strtolower($img->getClientOriginalExtension());
                $imgName    = $gen . '.' . $exe;
                $location   = 'images/profile/';
                $source     = $location . $imgName;
                $img->move($location, $imgName);

                $data->img = $source;

            }

            $data->save();

            if($data == true) {

                return response()->json([

                    'status'    => true,
                    'message'   => "Profile Updated Successfully",
                    'data'      => $data
        
                ], 200);

            }
            

        } else {

            return response()->json([

                'status'    => false,
                'message'   => "This Page Not Found",
            ], 404);
        }
    }
 
}
