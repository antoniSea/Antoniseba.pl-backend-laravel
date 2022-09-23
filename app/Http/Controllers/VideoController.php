<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use FFMpeg;
use FFMpeg\Format\Video\X264;
use Illuminate\Support\Str;
use App\Jobs\VideoProcess;
use Inertia\Inertia;
use App\Jobs\GenerateVideoThumbnail;

class VideoController extends Controller
{
  public function process_video (Request $request) {
    $name = Str::random(16);
    $path = $name . '.' . $request->photo->getClientOriginalExtension();
    $request->photo->storeAs('public', $path);
    
    $video = new Video;
    $video->name = $name;
    $video->path = asset('/storage/' . $name . '.m3u8');
    $video->progress = 0;
    $video->save();

    VideoProcess::dispatch($path, $name, $video);
    GenerateVideoThumbnail::dispatch($path, $name, $video);

    return redirect()->route('video-processing', ['id' => $video->id]);
  }

  public function show_video_processing (Int $id) {

    $video = Video::find($id);

    return Inertia::render('videoProcessing', [
      'video' => $video
    ]);
  }

  public function delete(Int $id)
  {
    $video = Video::findOrfail($id)->delete();

    return redirect()->route('dashboard');
  }
}
