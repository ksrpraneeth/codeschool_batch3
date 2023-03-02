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
        Schema::create('head_of_accounts', function (Blueprint $table) {
            $table->id();
            $table->string("hoa")->unique();
            $table->string("mjh");
            $table->string("mjh_desc")->nullable();
            $table->string("smjh");
            $table->string("smjh_desc")->nullable();
            $table->string("mih");
            $table->string("mih_desc")->nullable();
            $table->string("gsh");
            $table->string("gsh_desc")->nullable();
            $table->string("sh");
            $table->string("sh_desc")->nullable();
            $table->string("dh");
            $table->string("dh_desc")->nullable();
            $table->string("sdh");
            $table->string("sdh_desc")->nullable();
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
        Schema::dropIfExists('head_of_accounts');
    }
};
