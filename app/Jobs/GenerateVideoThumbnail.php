<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Video;
use FFMpeg;

class GenerateVideoThumbnail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $path;
    public $name;
    public $video;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($path, $name, Video $video)
    {
        $this->path = $path;
        $this->name = $name;
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        FFMpeg::fromDisk('public')
            ->open($this->path)
            ->getFrameFromSeconds(10)
            ->export()
            ->onProgress(function ($percentage) {
                $this->video->progress_thumbnail = $percentage;
                $this->video->save();
            })
            ->toDisk('thumbnail')
            ->save( $this->name . '.png');
        
        $this->video->path_thumbnail = '/storage/thumbnail/' . $this->name . '.png';
        $this->video->save();
        
    
    }
}
