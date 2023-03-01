<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertingDeductionTableData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('deductions')->insert([
            ['name'=>'pf employee','created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
            ['name'=>'Food deduction','created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
            ['name'=>'proffesional tax','created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
            ['name'=>'pf employeer','created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]
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
}
