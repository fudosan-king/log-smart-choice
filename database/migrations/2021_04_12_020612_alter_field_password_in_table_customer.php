<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterFieldPasswordInTableCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('password')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('social_id')->nullable();
            $table->renameColumn('social', 'social_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('password')->nullable(false)->default(0)->change();
            $table->string('email')->nullable(false)->default(0)->change();
            $table->dropColumn('social_id');
            $table->renameColumn('social_type', 'social');
        });
    }
}
