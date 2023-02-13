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
        DB::table('venues')->insert([

            ['name' => 'Nex Arena', 'phone' => '8688480603', 'address' => 'Sagar Plaza Building', 'area' => 'Abids', 'city' => 'Hyderabad', 'state' => 'Telangana', 'pincode' => '500095', 'thumbnail' => 'http://127.0.0.1:8000/assets/images/nex-arena-abids.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['name' => 'HotFut', 'phone' => '9177766005', 'address' => 'Kundanbagh Colony', 'area' => 'Begumpet', 'city' => 'Hyderabad', 'state' => 'Telangana', 'pincode' => '500016', 'thumbnail' => 'http://127.0.0.1:8000/assets/images/hotfut-begumpet.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['name' => 'Speed Box', 'phone' => '9363603636', 'address' => 'Maruthi Nagar', 'area' => 'Kothapet', 'city' => 'Hyderabad', 'state' => 'Telangana', 'pincode' => '500060', 'thumbnail' => 'http://127.0.0.1:8000/assets/images/speed-box.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['name' => 'Flying Lotus', 'phone' => '7337447665', 'address' => 'Road No. 12, MLA Colony', 'area' => 'Banjara Hills', 'city' => 'Hyderabad', 'state' => 'Telangana', 'pincode' => '500034', 'thumbnail' => 'http://127.0.0.1:8000/assets/images/flying-lotus.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['name' => 'Srinivas Tennis Academy', 'phone' => '9948551855', 'address' => 'Haripuri Colony, Bharat Nagar', 'area' => 'Bahadurguda', 'city' => 'Hyderabad', 'state' => 'Telangana', 'pincode' => '500035', 'thumbnail' => 'http://127.0.0.1:8000/assets/images/srinivas-tennis-academy.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['name' => 'Phoenix Sports', 'phone' => '7093412373', 'address' => 'Plot No. 148, Road No. 10, Arunodaya Nagar', 'area' => 'Nagole', 'city' => 'Hyderabad', 'state' => 'Telangana', 'pincode' => '500068',  'thumbnail' => 'http://127.0.0.1:8000/assets/images/phoenix-sports.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['name' => 'Ace Sports Arena', 'phone' => '9846235644', 'address' => 'Street No. 13, Nalanda Nagar', 'area' => 'Upperpally', 'city' => 'Hyderabad', 'state' => 'Telangana', 'pincode' => '500030', 'thumbnail' => 'http://127.0.0.1:8000/assets/images/ace-sports-arena.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['name' => 'Rampage Sports', 'phone' => '9956112565', 'address' => 'Road No. 86, Paramount Hills', 'area' => 'Jubilee Hills', 'city' => 'Hyderabad', 'state' => 'Telangana', 'pincode' => '500096', 'thumbnail' => 'http://127.0.0.1:8000/assets/images/rampage-sports.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['name' => 'Dream Basketball Academy', 'phone' => '9989561238', 'address' => 'Plot No. 4, Siddhi Vinayak Nagar', 'area' => 'Madhapur', 'city' => 'Hyderabad', 'state' => 'Telangana', 'pincode' => '500081', 'thumbnail' => 'http://127.0.0.1:8000/assets/images/dream-basketball-academy.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['name' => 'Turfside', 'phone' => '8565541155', 'address' => 'Road No. 10, Venkatagiri', 'area' => 'Jubilee Hills', 'city' => 'Hyderabad', 'state' => 'Telangana', 'pincode' => '500033', 'thumbnail' => 'http://127.0.0.1:8000/assets/images/turfside.jpg', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('venues')->truncate();
    }
};