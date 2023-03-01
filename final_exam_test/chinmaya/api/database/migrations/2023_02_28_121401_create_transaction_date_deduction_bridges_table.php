<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionDateDeductionBridgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_date_deduction_bridges', function (Blueprint $table) {
            $table->id();
            $table->integer('transaction_multipledates_id');
            $table->foreign('transaction_multipledates_id')->references('id')->on('transaction_multipledates');
            $table->integer('deduction_id');
            $table->foreign('deduction_id')->references('id')->on('deductions');
            $table->bigInteger('amount');
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
        Schema::dropIfExists('transaction_date_deduction_bridges');
    }
}
