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

        $user       = auth('sanctum')->user();

        $data = DB::table('carts')
        ->where('user_id', '=', $user->id)
        ->join('products', 'carts.product', 'products.id')
        ->select('carts.id' ,'carts.price', 'carts.quantity', 'carts.created_at', 'products.pro_name', 'products.img')
        ->latest()
        ->paginate(10);

        return response()->json([

            'status'    => true,
            'message'   => 'Fetch Cart All Products',
            'data'      => $data

        ], 200);

    } // End Method

}
