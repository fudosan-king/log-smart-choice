<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stations', function (Blueprint $table) {
            $table->dropColumn([
                'region_code', 'tran_company_code', 'station_code',
                'tran_company_full_name', 'tran_company_short_name',
                'old_name', 'number_change', 'value_change',
                'parent_flag'
            ]);
            $table->integer('transport_id');
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
            $table->integer('region_code')->nullable()->after('id');
            $table->integer('tran_company_code')->nullable()->after('region_code');
            $table->integer('station_code')->nullable()->after('tran_company_code');
            $table->string('tran_company_full_name')->nullable()->after('station_code');
            $table->string('tran_company_short_name')->nullable()->after('tran_company_full_name');
            $table->string('old_name')->nullable()->after('tran_company_short_name');
            $table->integer('number_change')->nullable()->after('name');
            $table->integer('value_change')->nullable()->after('number_change');
            $table->dropColumn('transport_id');
        });
    }
}
