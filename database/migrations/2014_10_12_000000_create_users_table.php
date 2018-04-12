<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->nullable()->default(null);
            $table->string('password')->nullable()->default(null);
            $table->text('image')->nullable()->default(null);
            $table->string('phone')->nullable()->default(null);
            $table->tinyInteger('gender')->nullable()->default(null); // name: 1, nữ: 0
            $table->text('token')->nullable()->default(null);
            $table->text('fcm_token')->nullable()->default(null);
            $table->text('facebook_token')->nullable()->default(null);
            $table->text('facebook_id')->nullable()->default(null);
            $table->text('chat_id')->nullable()->default(null);
            $table->text('country')->nullable()->default(null);
            $table->text('address')->nullable()->default(null);
            $table->text('city')->nullable()->default(null);
            $table->text('latitude')->nullable()->default(null);
            $table->text('longitude')->nullable()->default(null);
            $table->text('login_at')->nullable()->default(null);
            $table->text('suggest_at')->nullable()->default(null);
            $table->text('_suggested')->nullable()->default(null);
            $table->text('_cancelled')->nullable()->default(null);
            $table->text('_friend')->nullable()->default(null);
            $table->tinyInteger('role')->default(4); // super_admin: 1, admin: 2, mod: 3, member: 4
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
