<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Form;
use App\Models\FormType;
use App\Models\Hoa;
use App\Models\HoaForm;
use App\Models\IfscCode;
use App\Models\Scrutiny;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        IfscCode::firstOrCreate([
            'ifsc_code'=>'HDFC0000128',
            'bank_name'=>'HDFC BANK LTD',
            'state'=>'Chennai',
            'branch'=>'Chennai Credit Card Operations'
        ]);
        IfscCode::firstOrCreate([
            'ifsc_code'=>'SBIN0070264',
            'bank_name'=>'SBI Bank',
            'state'=>'Hyderabad',
            'branch'=>'Abids'
        ]);
        IfscCode::firstOrCreate([
            'ifsc_code'=>'SBIN0012917',
            'bank_name'=>'SBI Bank',
            'state'=>'Telangana',
            'branch'=>'Ramnagar'
        ]);
        Form::firstOrCreate([
            'form_number'=>'56',
        ]);
        Form::firstOrCreate([
            'form_number'=>'58',
        ]);
        FormType::firstOrCreate([
            'form_number_id'=>'1',
            'form_type'=>'WATER BILL CHARGES'
        ]);
        FormType::firstOrCreate([
            'form_number_id'=>'2',
            'form_type'=>'ELECTRICITY BILL CHARGES'
        ]);
        Hoa::firstOrCreate([
            'mjh'=>'2055',
            'mjh_desc'=>'Police',
            'smjh'=>'00',
            'smjh_desc'=>'NA',
            'mih'=>'108',
            'mih_desc'=>'State Headquarters Police',
            'gsh'=>'00',
            'gsh_desc'=>'NA',
            'sh'=>'05',
            'sh_desc'=>'City Police Force',
            'dh'=>'130',
            'dh_desc'=>'Office Expenses',
            'sdh'=>'133',
            'sdh_desc'=>'Water and Electricity Charges',
            'hoa'=>'205000180',
            'hoa_tier'=>'2055-00-108-05-130-10'
        ]);
        Hoa::firstOrCreate([
            'mjh'=>'2055',
            'mjh_desc'=>'Traffic',
            'smjh'=>'00',
            'smjh_desc'=>'NA',
            'mih'=>'108',
            'mih_desc'=>'Traffic State Headquarters Police',
            'gsh'=>'00',
            'gsh_desc'=>'NA',
            'sh'=>'05',
            'sh_desc'=>'Traffic City Police Force',
            'dh'=>'130',
            'dh_desc'=>'Office Expenses',
            'sdh'=>'133',
            'sdh_desc'=>'Electricity Charges',
            'hoa'=>'30560090',
            'hoa_tier'=>'2055-00-108-05-130-10'
        ]);
        HoaForm::firstOrCreate([
            'form_type_id'=>'1',
            'hoa_id'=>'1'
        ]);
        HoaForm::firstOrCreate([
            'form_type_id'=>'2',
            'hoa_id'=>'2'
        ]);
        Scrutiny::firstOrCreate([
            'form_type_id'=>'1',
            'scrutiny_desc'=>'Whether corresponding vouchers are enclosed',
        ]);
        Scrutiny::firstOrCreate([
            'form_type_id'=>'1',
            'scrutiny_desc'=>'Whether the bill is signed by theD D O, head of a/c is noted in 7 tier system, disccharge endorsement and non-drawl certificate with official seal in original(corbon copy not accepted)',
        ]);
        Scrutiny::firstOrCreate([
            'form_type_id'=>'1',
            'scrutiny_desc'=>'Whether the specimen signature on record is matching with the specimen signature on the bill and covered under proper(ink signed) sanction by a competent with corrections and alterations are attested with full signature of the DDO',
        ]);
        Scrutiny::firstOrCreate([
            'form_type_id'=>'2',
            'scrutiny_desc'=>'	Whether the sanction proceeding enclosed is given by the competant authority and it is within the financial powers delegated in G.O 148 and other G.O',
        ]);
        Scrutiny::firstOrCreate([
            'form_type_id'=>'2',
            'scrutiny_desc'=>'	Whether all sub vouchers or Invoices exceeding 1,000/-(proforma invoce not acceptable) are passed for payment with full siganture of the DDO and enclosed to the bill in support sanction amount',
        ]);
       
    }
}
