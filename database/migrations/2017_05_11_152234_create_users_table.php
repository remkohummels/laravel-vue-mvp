<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.php
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('email');
            $table->string('password');
            $table->tinyInteger('password_reset');
            $table->tinyInteger('active');
            $table->integer('user_type_id')->unsigned();
            $table->string('phone');
            $table->integer('sync_type_id')->unsigned();
            $table->timestamp('sync_date');
            $table->text('notes')->nullable();
            $table->string('remember_token')->nullable();

            $table->timestamps();

            $table->foreign('user_type_id')
                  ->references('id')
                  ->on('user_types')
                  ->onUpdate('cascade');
            $table->foreign('sync_type_id')
                  ->references('id')
                  ->on('sync_types')
                  ->onUpdate('cascade');
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
            $table->dropForeign('users_user_type_id_foreign');
            $table->dropForeign('users_sync_type_id_foreign');
        });
        Schema::dropIfExists('users');
    }
}
