<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BrandController extends Controller
{
    
    public function add_brand() {

        return view('dashboard.brands.add');

    } // End Method
}
