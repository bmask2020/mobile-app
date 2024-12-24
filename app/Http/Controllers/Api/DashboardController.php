<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   
    public function home() {

        return response()->json([
            'status'    => true,
            'message'   => 'App Home Page',
            'data'      => []

        ], 200);

    } // End Method
}