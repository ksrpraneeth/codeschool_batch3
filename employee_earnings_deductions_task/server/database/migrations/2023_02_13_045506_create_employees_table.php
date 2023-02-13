<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('department');
            $table->string('designation');
            $table->integer('bill_ids_id');
            $table->string('employee_code')->unique();
            $table->string('bank_ac_no')->unique();
            $table->timestamps();

            $table->foreign('bill_ids_id')->references('id')->on('bill_ids');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
