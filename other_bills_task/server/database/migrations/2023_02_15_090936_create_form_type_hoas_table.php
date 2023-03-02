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
        Schema::create('form_type_hoas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("form_type_id");
            $table->foreign("form_type_id")->references("id")->on("form_types");
            $table->bigInteger("head_of_account_id");
            $table->foreign("head_of_account_id")->references("id")->on("head_of_accounts");
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
        Schema::dropIfExists('form_type_hoas');
    }
};
