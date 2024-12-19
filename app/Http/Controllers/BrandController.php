<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Carbon\Carbon;

class BrandController extends Controller
{
    
    public function add_brand() {

        return view('dashboard.brands.add');

    } // End Method


    public function store_brand(Request $request) {

        $validated = $request->validate([
            'name'  => 'required|unique:brands',
            'img'   => 'required',

        ], [

            'name.required'     => 'Brand Name is Required',
            'name.unique'       => 'This Brand Added Before',
            'img.required'      => 'Brand Image is Required'
        ]);


        $brand      = strip_tags($request->name);

        $img        = $request->file('img');

        $gen        = hexdec(uniqid());
        $ex         = strtolower($img->getClientOriginalExtension());
        $name       = $gen . '.' . $ex;
        $location   = 'brand/';
        $source     = $location.$name;
        $img->move($location,$name);

        $Brand = Brand::insert([

            'name'          => $brand,
            'img'           => $source,
            'created_at'    => Carbon::now()

        ]);


        if($Brand == true) {

            return redirect()->back()->with('msg', 'Brand Add Success');

        } else {

            return redirect()->back()->with('msg', 'Brand Not Add Success');

        }

      

    } // End Method



    public function view_brand() {

        $data = Brand::latest()->paginate(10);

        return view('dashboard.brands.index', compact('data'));

    } // End Method



    public function edit_brand($id) {


        $data = Brand::findOrFail($id);

        return view('dashboard.brands.edit', compact('data'));

    } // end Method


    public function update_brand(Request $request) {


        $validated = $request->validate([
            'name' => 'required|unique:brands',
           
        ], [

            'name.required' => 'Brand Name is Required',
            'name.unique'   => 'The Brand Name Already Exists'
        ]);


        $id     = $request->id;
        $name   = strip_tags($request->name);


        $data = Brand::where('id', '=', $id)->first();

        $data->name = $name;

        if($request->hasFile('img')) {

            unlink($data->img);

            $img        = $request->file('img');
            $gen        = hexdec(uniqid());
            $ex         = strtolower($img->getClientOriginalExtension());
            $photo      = $gen. '.' .$ex;
            $location   = 'brand/';
            $source     = $location . $photo;
            $img->move($location, $photo);

            $data->img = $source;

        }

        $data->save();

        return redirect()->back()->with('msg', 'Brand Updated Success');

    } // End Method


}
