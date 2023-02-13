<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
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
        DB::table('venue_sport_mappings')->insert([

            ['venue_id' => '1', 'sport_id' => '4', 'price_per_hour' => '1500', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['venue_id' => '1', 'sport_id' => '3', 'price_per_hour' => '1500', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['venue_id' => '2', 'sport_id' => '4', 'price_per_hour' => '2000', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['venue_id' => '2', 'sport_id' => '3', 'price_per_hour' => '1800', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['venue_id' => '3', 'sport_id' => '1', 'price_per_hour' => '400', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['venue_id' => '3', 'sport_id' => '3', 'price_per_hour' => '600', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['venue_id' => '4', 'sport_id' => '1', 'price_per_hour' => '500', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['venue_id' => '5', 'sport_id' => '5', 'price_per_hour' => '300', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['venue_id' => '6', 'sport_id' => '1', 'price_per_hour' => '350', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['venue_id' => '7', 'sport_id' => '3', 'price_per_hour' => '1000', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['venue_id' => '8', 'sport_id' => '3', 'price_per_hour' => '1200', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['venue_id' => '8', 'sport_id' => '4', 'price_per_hour' => '1300', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['venue_id' => '9', 'sport_id' => '2', 'price_per_hour' => '3000', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['venue_id' => '10', 'sport_id' => '4', 'price_per_hour' => '2200', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('venue_sport_mappings')->truncate();
    }
};
