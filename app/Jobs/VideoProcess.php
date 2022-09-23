<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use FFMpeg\Format\Video\X264;
use App\Models\Video;
use FFMpeg;
use FFMpeg\Format\ProgressListener\AbstractProgressListener;
use ProtoneMedia\LaravelFFMpeg\FFMpeg\ProgressListenerDecorator;

class VideoProcess implements ShouldQueue
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
        $format = new \FFMpeg\Format\Video\X264;
        $decoratedFormat = ProgressListenerDecorator::decorate($format);

        $lowBitrate = (new X264)->setKiloBitrate(250);
        $midBitrate = (new X264)->setKiloBitrate(500);
        $highBitrate = (new X264)->setKiloBitrate(1000);

        FFMpeg::fromDisk('public')
            ->open($this->path)
            ->exportForHLS()
            ->onProgress(function ($percentage) {
                $this->video->progress = $percentage;
                $this->video->save();
            })
            ->inFormat($decoratedFormat)
            ->setSegmentLength(10) // optional
            ->setKeyFrameInterval(48) // optional
            ->addFormat($lowBitrate)
            ->addFormat($midBitrate)
            ->addFormat($highBitrate)
            ->save( $this->name . '.m3u8');

        $this->video->progress = 100;
        $this->video->save();


    }
}
