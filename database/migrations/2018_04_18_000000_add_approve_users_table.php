<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApproveUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
    */
    public function up() 
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('_approve')->nullable()->default(null);
            $table->renameColumn('_cancelled', '_passed');
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
            $table->dropColumn(['_approve']);
            $table->renameColumn('_passed', '_cancelled');
        });
    }
}
