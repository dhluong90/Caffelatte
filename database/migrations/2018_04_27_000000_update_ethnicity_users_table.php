<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEthnicityUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
    */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('ethnicity')->nullable()->default(null);
        });
    }
     /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['ethnicity']);
        });
    }
}
