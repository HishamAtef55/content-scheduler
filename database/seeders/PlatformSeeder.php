<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $platforms = [
            ['name' => 'Twitter',   'icon' => 'fab fa-twitter'],
            ['name' => 'Instagram', 'icon' => 'fab fa-instagram'],
            ['name' => 'LinkedIn',  'icon' => 'fab fa-linkedin'],
            ['name' => 'Facebook',  'icon' => 'fab fa-facebook'],
            ['name' => 'TikTok',    'icon' => 'fab fa-tiktok'],
            ['name' => 'YouTube',   'icon' => 'fab fa-youtube'],
        ];

        collect($platforms)->each(
            fn($platform) => Platform::firstOrCreate(['name' => $platform['name']], $platform)
        );
    }
}
