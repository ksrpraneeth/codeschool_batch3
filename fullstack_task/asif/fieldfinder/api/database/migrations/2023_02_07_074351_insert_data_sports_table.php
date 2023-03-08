<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('sports')->insert([

            ['name' => 'Badminton', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['name' => 'Basketball', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['name' => 'Cricket', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['name' => 'Football', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['name' => 'Tennis', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
