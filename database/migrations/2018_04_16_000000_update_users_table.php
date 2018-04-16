<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
    */
    public function up() 
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('language')->nullable()->default(null);
            $table->unsignedInteger('height')->nullable()->default(null);
            $table->text('education')->nullable()->default(null);
            $table->text('occupation')->nullable()->default(null);
            $table->text('sumary')->nullable()->default(null);
            $table->text('information')->nullable()->default(null);
            $table->text('religion')->nullable()->default(null);
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
            $table->dropColumn(['language', 'height', 'education', 'occupation', 'sumary', 'information', 'religion']);
        });
    }
}
