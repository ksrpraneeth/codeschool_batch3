<?php
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class InsertingDataInEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       DB::table('employees')->insert([
        ['employee_unique_id'=>'123456','name'=>'Chinmaya biswal','designation'=>'Software developer','created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
        ['employee_unique_id'=>'456789','name'=>'susil biswal','designation'=>'Software tester','created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
        ['employee_unique_id'=>'789123','name'=>'salman khan','designation'=>'manager','created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
        ['employee_unique_id'=>'456123','name'=>'virat kohli','designation'=>'Software Engineer','created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
       ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee', function (Blueprint $table) {
            //
        });
    }
}
