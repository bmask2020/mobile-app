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
        $product = Product::all();

        return response()->json([
            'status'    => true,
            'message'   => 'App Home Page',
            'brand'     => $brand,
            'product'   => $product

        ], 200);

    } // End Method
}
