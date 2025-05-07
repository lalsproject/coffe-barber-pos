<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $setting = Setting::firstOrCreate([], [
            'logo' => '',
            'button_color' => '#5A080C',
            'background_color' => '#ffffff',
            'input_color' => '#5A080C',
            'text_color' => '#5A080C',
            'icon_color' => '#5A080C',
            'navbar_background' => '#F2F2F2',
            'sidebar_background' => '#F2F2F2',
        ]);

        if ($setting->wasRecentlyCreated) {
            $this->command->info('Settings record created successfully.');
        } else {
            $this->command->info('Settings record already exists.');
        }
    }
}
