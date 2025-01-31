<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'urgent_amount_big' => 100,
            'expose_amount_big' => 500,
            'media_amount_big'  => 0,
            'urgent_amount_small' => 100,
            'expose_amount_small' => 200,
            'media_amount_small'  => 0
        ]);
    }
}
