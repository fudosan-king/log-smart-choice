<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableResetPasswordAddPrimaryKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('password_resets')) {
            Schema::table('password_resets', function (Blueprint $table) {
                $table->primary('email');
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
        if (Schema::hasTable('password_resets')) {
            Schema::table('password_resets', function (Blueprint $table) {
                $table->dropPrimary('password_resets_email_primary');
            });
        }
    }
}
