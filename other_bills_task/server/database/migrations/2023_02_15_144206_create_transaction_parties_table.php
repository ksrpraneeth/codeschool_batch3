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
        Schema::create('transaction_parties', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("transaction_id");
            $table->foreign("transaction_id")->references("id")->on("transactions");
            $table->string("agency_account_number");
            $table->foreign("agency_account_number")->references("account_number")->on("agencies");
            $table->string("agency_name");
            $table->string("agency_gst")->nullable();
            $table->string("agency_ifsc_code");
            $table->string("agency_bank_name");
            $table->string("agency_bank_branch");
            $table->bigInteger("gross");
            $table->bigInteger("pt");
            $table->bigInteger("tds");
            $table->bigInteger("gst");
            $table->bigInteger("gis");
            $table->bigInteger("thn");
            $table->bigInteger("net");
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
        Schema::dropIfExists('transaction_parties');
    }
};
