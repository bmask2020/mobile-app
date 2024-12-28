<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product;

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

        ]);

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

        ]);


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

        ]);

    } // End Method

}
