<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('old_id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('email');
            $table->string('password');
            $table->tinyInteger('password_reset');
            $table->tinyInteger('active');
            $table->tinyInteger('user_type_id');
            $table->string('phone');
            $table->integer('sync_type_id');
            $table->timestamp('sync_date');
            $table->text('notes')->nullable();
            $table->timestamp('old_created_at');
            $table->timestamp('old_updated_at');

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
        Schema::dropIfExists('users_history');
    }
}
