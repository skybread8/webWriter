<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteSetting::updateOrCreate(
            ['id' => 1],
            [
                'site_name' => 'Kevin Pérez Alarcón',
                'tagline' => '',
                'hero_text' => 'Escritor independiente. Más de 5.000 libros vendidos en las calles.',
                'hero_image' => null,
                'contact_email' => 'admin@example.com',
            ]
        );
    }
}
