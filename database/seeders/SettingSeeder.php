<?php

namespace Database\Seeders;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings=[

            // contact information
            ["key" => "support_email", "value" => "support@interpay.com", "type" => "email"],
            ["key" => "support_phone", "value" => "+9661234567", "type" => "phone"],

        ];

        foreach ($settings as $setting){
            Setting::firstOrCreate($setting);
        }
    }
}
