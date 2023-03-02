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
        Schema::create('agencies', function (Blueprint $table) {
            $table->id();
            $table->string("agency_name");
            $table->string("account_number")->unique();
            $table->string("gst_no")->nullable()->unique();
            $table->string('ifsc_code', 11);
            $table->timestamps();

            $table->foreign("ifsc_code")->references("ifsc_code")->on("ifsc_codes");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agencies');
    }
};
