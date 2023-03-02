<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\FormNumber;
use App\Models\FormTypeHoa;
use App\Models\HeadOfAccount;
use App\Models\IfscCode;
use App\Models\ScrutinyItem;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        IfscCode::firstOrCreate([
            "ifsc_code" => "SBIN0012906",
            "bank_name" => "SBI",
            "state" => "Telangana",
            "branch" => "Rotary Nagar"
        ]);

        $formNumber85 = FormNumber::firstOrCreate(["form_number" => '85']);
        $formNumber83 = FormNumber::firstOrCreate(["form_number" => '83']);
        $formType = $formNumber85->formTypes()->firstOrCreate(["form_type" => "Water Bill"]);

        $hoa = HeadOfAccount::firstOrCreate([
            "hoa" => "2055001080005130133NVN",
            "mjh" => '2055',
            "mjh_desc" => 'Police',
            "smjh" => '00',
            "smjh_desc" => 'NA',
            "mih" => '108',
            "mih_desc" => 'State Head Quarters',
            "gsh" => '00',
            "gsh_desc" => 'NA',
            "sh" => '05',
            "sh_desc" => 'City Police',
            "dh" => '130',
            "dh_desc" => 'Office Expenses',
            "sdh" => "133",
            "sdh_desc" => "Water and Electricity Charges",
        ]);

        FormTypeHoa::firstOrCreate(["form_type_id" => $formType->id, "head_of_account_id" => $hoa->id]);
        ScrutinyItem::firstOrCreate([
            "form_type_id" => $formType->id,
            "scrutiny_desc" => "Whether corresponding vouchers are enclosed"
        ]);
        ScrutinyItem::firstOrCreate([
            "form_type_id" => $formType->id,
            "scrutiny_desc" => "Whether the bill is signed by theD D O, head of a/c is noted in 7 tier system, disccharge endorsement and non-drawl certificate with official seal in original(corbon copy not accepted)"
        ]);
        ScrutinyItem::firstOrCreate([
            "form_type_id" => $formType->id,
            "scrutiny_desc" => "Whether the claim is with in alloted budget	"
        ]);
        ScrutinyItem::firstOrCreate([
            "form_type_id" => $formType->id,
            "scrutiny_desc" => "Whether the claim is with in alloted budget	"
        ]);
        ScrutinyItem::firstOrCreate([
            "form_type_id" => $formType->id,
            "scrutiny_desc" => "Whether the work order/purchase order is enclosed"
        ]);
    }
}
