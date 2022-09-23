<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            
            // file info
            $table->string('name');
            $table->string('path')->nullable();
            $table->string('progress')->nullable();

            // video info
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('tags')->nullable();

            // thumbnail info
            $table->string('path_thumbnail')->nullable();
            $table->string('progress_thumbnail')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
};
