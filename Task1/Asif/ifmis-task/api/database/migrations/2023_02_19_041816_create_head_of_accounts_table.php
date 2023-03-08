<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('head_of_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('mjh');
            $table->string('mjh_desc');
            $table->string('smjh');
            $table->string('smjh_desc');
            $table->string('mih');
            $table->string('mih_desc');
            $table->string('gsh');
            $table->string('gsh_desc');
            $table->string('sh');
            $table->string('sh_desc');
            $table->string('dh');
            $table->string('dh_desc');
            $table->string('sdh');
            $table->string('sdh_desc');
            $table->string('hoa')->unique();
            $table->string('hoa_tier');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('head_of_accounts');
    }
};
