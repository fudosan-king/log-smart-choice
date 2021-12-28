<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('post_image')) {
            Schema::create('post_image', function (Blueprint $table) {
                $table->id();
                $table->string('class_css');
                $table->string('image_url');
                $table->string('post_id');
                $table->timestamps();
            });
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('post_image')) {
            Schema::dropIfExists('post_image');
        }
    }
}
