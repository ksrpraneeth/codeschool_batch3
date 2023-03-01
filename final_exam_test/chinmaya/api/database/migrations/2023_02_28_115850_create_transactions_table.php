<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->index();
            $table->foreign('employee_id')->references('employee_unique_id')->on('employees');
            $table->integer('bill_type_id');
            $table->foreign('bill_type_id')->references('id')->on('bill_types');
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
        Schema::dropIfExists('transactions');
    }
}
