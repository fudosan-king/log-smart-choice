<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRomajiFieldInDistrictAndStationCityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('district', function (Blueprint $table) {
            $table->string('name_romaji')->nullable()->after('name');
        });

        Schema::table('city', function (Blueprint $table) {
            $table->string('name_romaji')->nullable()->after('name');
        });

        Schema::table('stations', function (Blueprint $table) {
            $table->string('name_romaji')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('district', function (Blueprint $table) {
            $table->dropColumn('name_romaji');
        });

        Schema::table('city', function (Blueprint $table) {
            $table->dropColumn('name_romaji');
        });

        Schema::table('stations', function (Blueprint $table) {
            $table->dropColumn('name_romaji');
        });
    }
}
