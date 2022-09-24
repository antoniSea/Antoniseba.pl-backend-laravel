<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;

class VideoController extends Controller
{
    public function show (Int $id) {
        $Video = Video::findorfail($id);

        return response($Video);
    }

    public function update (Int $id, Request $request) {
        $Video = Video::findorfail($id);
        $Video->title = $request->title;
        $Video->description = $request->description;
        $Video->tags = $request->tags;
        $Video->public = $request->public;
        $Video->save();

        return response($Video);
    }

    public function index () {
        $Video = Video::paginate(5);
        
        return response($Video);
    }
}
