<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;

class ProductController extends Controller
{
    
    public function add_product() {

        $brand = Brand::all();

        return view('dashboard.products.add', compact('brand'));

    } // End Method
}
