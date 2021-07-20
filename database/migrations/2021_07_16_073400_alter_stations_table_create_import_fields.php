<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterStationsTableCreateImportFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stations', function (Blueprint $table) {
            $table->integer('region_code')->nullable()->after('id');
            $table->integer('tran_company_code')->nullable()->after('region_code');
            $table->integer('station_code')->nullable()->after('tran_company_code');
            $table->string('tran_company_full_name')->nullable()->after('station_code');
            $table->string('tran_company_short_name')->nullable()->after('tran_company_full_name');
            $table->string('old_name')->nullable()->after('tran_company_short_name');
            $table->integer('number_change')->nullable()->after('name');
            $table->integer('value_change')->nullable()->after('number_change');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stations', function (Blueprint $table) {
            $table->dropColumn('region_code');
            $table->dropColumn('tran_company_code');
            $table->dropColumn('station_code');
            $table->dropColumn('tran_company_full_name');
            $table->dropColumn('tran_company_short_name');
            $table->dropColumn('old_name');
            $table->dropColumn('number_change');
            $table->dropColumn('value_change');
            
        });
    }
}
