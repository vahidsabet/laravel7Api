<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // `orderNo`, `tel`, `cName`, `postSent`, `mSent`, `destAr`, `pCode`
            $table->integer('orderNo')->nullable();
            $table->string('tel', 50,)->nullable();
            $table->string('cName', 50)->nullable();
            $table->boolean('postSent')->nullable();
            $table->boolean('mSent')->nullable();
            $table->boolean('destAr')->nullable();
            $table->string('pCode', 50)->nullable();
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
        Schema::dropIfExists('orders');
    }
}
