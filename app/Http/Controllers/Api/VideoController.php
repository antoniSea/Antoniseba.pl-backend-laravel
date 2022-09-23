<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;

class VideoController extends Controller
{
    public function show (Int $id) {
        $Video = Video::findorfail($id);
        return $Video;
    }

    public function update (Int $id, Request $request) {
        $Video = Video::findorfail($id);
        $Video->title = $request->title;
        $Video->description = $request->description;
        $Video->tags = $request->tags;
        $Video->save();

        return response($Video);
    }
}
