<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionMultipleDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_multiple_dates', function (Blueprint $table) {
            $table->id();
            
            $table->integer('transaction_id');
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('total_earning');
            $table->string('total_deduction');
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
        Schema::dropIfExists('transaction_multiple_dates');
    }
}
