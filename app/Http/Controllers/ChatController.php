<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Support;
class ChatController extends Controller
{
    
    public function show_live_message($id) {

        Support::where('sender', '=', $id)->update([
            'status'    => true
        ]);

        $data = Support::where('sender', '=', $id)->get();
        
        return view('dashboard.live_chat.show', compact('data'));
     

    } // End Method
} 
