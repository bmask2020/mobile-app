<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Support;
use Illuminate\Support\Facades\DB;
class ChatController extends Controller
{
    
    public function show_live_message($id) {

        Support::where('sender', '=', $id)->update([
            'status'    => true
        ]);

        $data = Support::where('sender', '=', $id)->first();
        
        $message = DB::table('supports')
        ->where('message_no', '=', $data->message_no)
        ->join('users', 'supports.sender', 'users.id')
        ->select('supports.message_no', 'supports.sender', 'supports.message', 'supports.created_at', 'users.name')
        ->get();

        return view('dashboard.live_chat.show', compact('message'));
     

    } // End Method
} 
