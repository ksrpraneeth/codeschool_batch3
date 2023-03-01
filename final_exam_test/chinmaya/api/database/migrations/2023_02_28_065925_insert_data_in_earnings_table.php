<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertDataInEarningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       DB::table('earnings')->insert([
        ['name'=>'Basic','created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
        ['name'=>'CA','created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
        ['name'=>'HRA','created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
        ['name'=>'medical','created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]
       ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('earnings', function (Blueprint $table) {
            //
        });
    }
}
