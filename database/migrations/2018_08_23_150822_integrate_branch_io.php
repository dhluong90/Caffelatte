<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IntegrateBranchIo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->text('share_link')->nullable()->default(null);
            $table->text('share_link_id')->nullable()->default(null);
            $table->timestamp('share_link_created_at')->nullable()->default(\Carbon\Carbon::now());
            $table->integer('click')->nullable()->default(0);
            $table->integer('share')->nullable()->default(0);
            $table->integer('open')->nullable()->default(0);
        });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['share_link', 'share_link_id', 'share_link_created_at', 'click', 'share', 'open']);
        });
    }
}
