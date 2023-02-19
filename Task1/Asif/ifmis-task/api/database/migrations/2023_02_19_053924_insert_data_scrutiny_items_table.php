<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('scrutiny_items')->insert([
            ['form_type_id' => 1, 'description' => "Whether corresponding vouchers are enclosed", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['form_type_id' => 1, 'description' => "Whether the bill is signed by theD D O, head of a/c is noted in 7 tier system, disccharge endorsement and non-drawl certificate with official seal in original(corbon copy not accepted)", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['form_type_id' => 1, 'description' => "Whether the specimen signature on record is matching with the specimen signature on the bill and covered under proper(ink signed) sanction by a competent with corrections and alterations are attested with full signature of the DDO", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['form_type_id' => 1, 'description' => "Whether the sanction proceeding enclosed is given by the competant authority and it is within the financial powers delegated in G.O 148 and other G.O's", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['form_type_id' => 1, 'description' => "Whether all sub vouchers or Invoices exceeding 1,000/-(proforma invoce not acceptable) are passed for payment with full siganture of the DDO and enclosed to the bill in support sanction amount", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['form_type_id' => 1, 'description' => "Whether the sales tax is recorded in the invoices and the income tax is recoverable at source on gross amount with prescribed rate", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['form_type_id' => 1, 'description' => "Whether the articles or materials have been purchased in prescribed system of Art. 125 A.P.F.C and recorded in the stock register/log book in the prescribed manner with page no.", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['form_type_id' => 1, 'description' => "Whether the advance stamp reciept/advance receipt is enclosed and the discharge endorsement is in favour of third party", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['form_type_id' => 1, 'description' => "Whether the claim is with in alloted budget", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['form_type_id' => 1, 'description' => "Whether the work order/purchase order is enclosed", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['form_type_id' => 1, 'description' => "Whether the bill is preffered in prescribed TSTC Form", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['form_type_id' => 1, 'description' => "Whether the Bank details are enclose", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('scrutiny_items')->truncate();
    }
};
