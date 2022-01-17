<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDisctrictTableAddRomajiColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('district')) {
            Schema::table('district', function (Blueprint $table) {
                $table->string('romaji_name')->after('name');
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
        if (Schema::hasColumn('district', 'romaji_name')) {
            Schema::table('district', function (Blueprint $table) {
                $table->dropColumn('romaji_name');
            });
        }
    }
}
