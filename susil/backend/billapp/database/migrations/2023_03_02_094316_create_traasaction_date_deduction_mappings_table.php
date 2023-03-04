<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTraasactionDateDeductionMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traasaction_date_earning_mappings', function (Blueprint $table) {
            $table->id();
            $table->integer('transaction_multipledates_id');
            $table->foreign('transaction_multipledates_id')->references('id')->on('transaction_multiple_dates');
            $table->integer('earning_id');
            $table->foreign('earning_id')->references('id')->on('earnings');
            $table->integer('amount');

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
        Schema::dropIfExists('traasaction_date_deduction_mappings');
    }
}
