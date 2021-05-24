<?php

use App\Models\Customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBirthdayAndAnnouncementConditionColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->char('birthday', 50)->after('email')->nullable();
            $table->text('announcement_condition')->after('password')->nullable();
            $table->smallInteger('role3d')->default(Customer::ROLE_3D_CUSTOMER)->change();
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
            $table->dropColumn(['birthday', 'announcement_condition']);
            $table->smallInteger('role3d')->change();
        });
    }
}
