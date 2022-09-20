<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\contactMailCustomer;
use App\Models\Message;

class SendMessageController extends Controller
{
    public function send_message (Request $request) {

        $message = new Message;
        $message->name = $request->name;
        $message->email = $request->email;
        $message->message = $request->message;
        $message->save();

        Mail::to($request->email)->send(new contactMailCustomer($request));

        return response(200, $message);
    }
}
 