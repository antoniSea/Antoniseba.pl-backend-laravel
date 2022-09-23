<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Message;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::all();

        return Inertia::render('message/index', [
            'messages' => $messages
        ]);
    }

    public function destroy($id)
    {
        Message::findorfail($id)->delete();

        return redirect()->route('messages.index');
    }

    public function show($id)
    {
        $message = Message::findorfail($id);

        return Inertia::render('message/show', [
            'message' => $message
        ]);
    }
}
