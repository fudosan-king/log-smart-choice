<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditColFieldTableDataRows extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_rows', function (Blueprint $table) {
            $dataEstate = DB::table('data_types')->where('name', 'estates')->get();
            if ($dataEstate) {
                DB::table('data_rows')
                    ->insert([
                        'data_type_id' => $dataEstate[0]->id,
                        'field'        => 'estate_equipment',
                        'type'         => 'text',
                        'display_name' => 'Estate Equipment',
                        'required'     => 0,
                        'browse'       => 0,
                        'read'         => 1,
                        'edit'         => 1,
                        'add'          => 1,
                        'delete'       => 1,
                        'order'        => 7,
                    ]);
                DB::table('data_rows')
                    ->insert([
                        'data_type_id' => $dataEstate[0]->id,
                        'field'        => 'estate_flooring',
                        'type'         => 'text',
                        'display_name' => 'Estate Flooring',
                        'required'     => 0,
                        'browse'       => 0,
                        'read'         => 1,
                        'edit'         => 1,
                        'add'          => 1,
                        'delete'       => 1,
                        'order'        => 8,
                    ]);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('data_types')) {
            $dataEstate = DB::table('data_types')->where('name', 'estates')->get();
            if ($dataEstate) {
                DB::table('data_rows')
                    ->where('data_type_id', $dataEstate[0]->id)
                    ->where('field', 'estate_equipment')
                    ->delete();

                DB::table('data_rows')
                    ->where('data_type_id', $dataEstate[0]->id)
                    ->where('field', 'estate_flooring')
                    ->delete();
            }
        }
    }
}
