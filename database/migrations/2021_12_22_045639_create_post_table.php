<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('post')) {
            Schema::create('post', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('title_signal');
                $table->string('title_image');
                $table->string('top_image');
                $table->boolean('status')->default(true);
                $table->text('content');
                $table->string('page_post');
                $table->string('tag_post_id');
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
        if (Schema::hasTable('post')) {
            Schema::dropIfExists('post');
        }
    }
}
