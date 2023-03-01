<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionMultipledatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_multipledates', function (Blueprint $table) {
            $table->id();
            $table->integer('transaction_id')->index();
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->date('start_date');
            $table->date('end_date');
            $table->bigInteger('total_earning');
            $table->bigInteger('total_deduction');
            $table->bigInteger('net');
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
        Schema::dropIfExists('transaction_multipledates');
    }
}
