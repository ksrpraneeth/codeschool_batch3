<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertDataInBillTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      DB::table('bill_types')->insert([
        ['name'=>'water bill','created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
        ['name'=>'Electricity bill','created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
        ['name'=>'material bill','created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
        ['name'=>'petrol bill','created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
        ['name'=>'service bill','created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],

      ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bill_types', function (Blueprint $table) {
            //
        });
    }
}
