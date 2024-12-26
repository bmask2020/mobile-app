<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product;
use Carbon\Carbon;

class ProductController extends Controller
{
    
    public function add_product() {

        $brand          = Brand::all();
        return view('dashboard.products.add', compact('brand'));

    } // End Method


    public function store_product(Request $request) {

        if($request->isMethod('post')) {


            $validated = $request->validate([
                'pro_name'      => 'required|unique:products|max:255',
                'price'         => 'required',
                'brand'         => 'required',
                'avalibale'     => 'required',
                'img'           => 'required'
            ]);


            $pro_name   = strip_tags($request->pro_name);
            $price      = strip_tags($request->price);
            $brand      = strip_tags($request->brand);
            $avalibale  = strip_tags($request->avalibale);
            $details    = strip_tags($request->details);

            $img = $request->file('img');
            
            $gen        = hexdec(uniqid());
            $ex         = strtolower($img->getClientOriginalExtension());
            $name       = $gen . '.' . $ex;
            $location   = 'product/';
            $source     = $location . $name;
            $img->move($location, $name);


            $data = Product::insert([

                'pro_name'      => $pro_name,
                'price'         => $price,
                'brand'         => $brand,
                'img'           => $source,
                'avalibale'     => $avalibale,
                'details'       => $details,
                'created_at'    => Carbon::now()

            ]);


            if($data == true) {

                return redirect()->back()->with('msg', 'Product Add Success');

            } else {

                return redirect()->back()->with('msg', 'Product Not Add Success');
            }

          

        } else {

            return redirect()->route('login');
        }

    } // End Method



    public function view_products() {

        $data = Product::latest()->paginate(10);

        return view('dashboard.products.view', compact('data'));

    } // End Method



    public function edit_product($id) {

        $data   = Product::findOrFail($id);
        $brand  = Brand::all();

        return view('dashboard.products.edit', compact('data', 'brand'));

    } // End Method


    public function update_product(Request $request) {

        if($request->isMethod('post')) {

            $validated = $request->validate([
                'pro_name'      => 'required',
                'price'         => 'required',
                'brand'         => 'required',
                'avalibale'     => 'required'
            ]);

            $pro_name       = strip_tags($request->pro_name);
            $price          = strip_tags($request->price);
            $brand          = strip_tags($request->brand);
            $avalibale      = strip_tags($request->avalibale);
            $id             = $request->id;
            $details        = strip_tags($request->details);

            $product        = Product::findOrFail($id);

            if($request->hasFile('img')) {

                unlink($product->img);

                $img = $request->file('img');

                $gen = hexdec(uniqid());
                $ex  = strtolower($img->getClientOriginalExtension());
                $photo = $gen. '.' . $ex;
                $location = 'product/';

                $source = $location . $photo;
                $img->move($location, $photo);

                $product->img = $source;
                
            }

            $product->pro_name      = $pro_name;
            $product->price         = $price;
            $product->brand         = $brand;
            $product->avalibale     = $avalibale;
            $product->details       = $details;
            $product->save();

            return redirect()->back()->with('msg', 'Product Updated Success');
           

        } else {

            return redirect()->route('login');
        }

    } // End Method


    public function delete_product($id) {

        $data = Product::findOrFail($id);

        unlink($data->img);

        $data->delete();

        return redirect()->back()->with('msg', 'Product Deleted Success');
      

    } // End Method
}
