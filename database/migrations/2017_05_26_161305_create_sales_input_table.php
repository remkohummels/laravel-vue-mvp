<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesInputTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_input', function (Blueprint $table) {
            $table->increments('id');
            $table->string('restaurant_id')->length(20);
            $table->date('date');
            $table->tinyInteger('ignore');

            $table->decimal('0100', 13, 2);
            $table->decimal('0200', 13, 2);
            $table->decimal('0300', 13, 2);
            $table->decimal('0400', 13, 2);
            $table->decimal('0500', 13, 2);
            $table->decimal('0600', 13, 2);
            $table->decimal('0700', 13, 2);
            $table->decimal('0800', 13, 2);
            $table->decimal('0900', 13, 2);
            $table->decimal('1000', 13, 2);
            $table->decimal('1100', 13, 2);
            $table->decimal('1200', 13, 2);
            $table->decimal('1300', 13, 2);
            $table->decimal('1400', 13, 2);
            $table->decimal('1500', 13, 2);
            $table->decimal('1600', 13, 2);
            $table->decimal('1700', 13, 2);
            $table->decimal('1800', 13, 2);
            $table->decimal('1900', 13, 2);
            $table->decimal('2000', 13, 2);
            $table->decimal('2100', 13, 2);
            $table->decimal('2200', 13, 2);
            $table->decimal('2300', 13, 2);
            $table->decimal('2400', 13, 2);

            $table->timestamps();

            $table->foreign('restaurant_id')
                  ->references('restaurant_id')
                  ->on('restaurants')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_input', function (Blueprint $table) {
            $table->dropForeign('sales_input_restaurant_id_foreign');
        });
        Schema::dropIfExists('sales_input');
    }
}
