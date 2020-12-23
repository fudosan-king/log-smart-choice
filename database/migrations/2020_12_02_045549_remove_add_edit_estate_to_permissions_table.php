<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Models\Permission;

class RemoveAddEditEstateToPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permissions', function (Blueprint $table) {
            if (Schema::hasColumn('permissions', 'key')) {
                $addEstate = $this->_getDataPermission('key', 'add_estate');
                if ($addEstate) {
                    $this->_deleteDataPermission('key', 'add_estate');
                }

                $deleteEstate = $this->_getDataPermission('key', 'delete_estate');
                if ($deleteEstate) {
                    $this->_deleteDataPermission('key', 'delete_estate');
                }
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
        Schema::table('permissions', function (Blueprint $table) {
            $addEstate = $this->_getDataPermission('key', 'add_estate');
            $deleteEstate = $this->_getDataPermission('key', 'delete_estate');

            if ($addEstate->isEmpty()) {
                $permission = new Permission();
                $permission->key = 'add_estate';
                $permission->table_name = 'estates';
                $permission->save();
            }
            if ($deleteEstate->isEmpty()) {
                $permission = new Permission();
                $permission->key = 'delete_estate';
                $permission->table_name = 'estates';
                $permission->save();
            }
        });
    }

    private function _getDataPermission($column, $value)
    {
        return DB::table('permissions')->where($column, $value)->get();
    }

    private function _deleteDataPermission($colum, $value)
    {
        return DB::table('permissions')->where($colum, $value)->delete();
    }
}
