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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("form_type_id");
            $table->foreign("form_type_id")->references("id")->on("form_types");
            $table->string("hoa");
            $table->foreign("hoa")->references("hoa")->on("head_of_accounts");
            $table->string("reference_number");
            $table->string("purpose");
            $table->bigInteger("total_gross");
            $table->bigInteger("total_pt");
            $table->bigInteger("total_tds");
            $table->bigInteger("total_gst");
            $table->bigInteger("total_gis");
            $table->bigInteger("total_thn");
            $table->bigInteger("total_net");
            $table->bigInteger("tbr_no");
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
};
