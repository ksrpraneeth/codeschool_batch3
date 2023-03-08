<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
Use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $items = DB::table('venue_sport_mappings')->get();

        foreach($items as $item) {

            DB::table('time_slots')->insert([

                ['venue_sport_mappings_id' => $item->id, 'slotname' => 'Morning(6AM - 10AM)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now() ],
                ['venue_sport_mappings_id' => $item->id, 'slotname' => 'Afternoon(10AM - 2PM)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now() ],
                ['venue_sport_mappings_id' => $item->id, 'slotname' => 'Evening(2PM - 6PM)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now() ],
                ['venue_sport_mappings_id' => $item->id, 'slotname' => 'Night(6PM - 10PM)', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now() ]

            ]);
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('time_slots')->truncate();
    }
};
