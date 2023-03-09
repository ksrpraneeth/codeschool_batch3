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
        Schema::create('hoas', function (Blueprint $table) {
            $table->id();
            $table->integer('mjh');
            $table->string('mjh_desc');
            $table->integer('smjh');
            $table->string('smjh_desc');
            $table->integer('mih');
            $table->string('mih_desc');
            $table->integer('gsh');
            $table->string('gsh_desc');
            $table->integer('sh');
            $table->string('sh_desc');
            $table->integer('dh');
            $table->string('dh_desc');
            $table->integer('sdh');
            $table->string('sdh_desc');
            $table->integer('hoa');
            $table->string('hoa_tier');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoas');
    }
};
