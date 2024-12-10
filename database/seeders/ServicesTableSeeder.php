<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Dental Cleaning (Oral Prophylaxis)',
                'description' => 'A cleaning procedure to remove plaque and tartar.',
                'duration' => '30-60',
                'price' => 50.00,
                'reserve_fee' => 50.00,
                'for_guest' => 1, // Added for_guest value
            ],
            [
                'name' => 'Tooth Filling',
                'description' => 'Restoring a tooth that has been damaged.',
                'duration' => '20-45',
                'price' => 80.00,
                'reserve_fee' => 80.00,
                'for_guest' => 1, // Added for_guest value
            ],
            [
                'name' => 'Extraction',
                'description' => 'Removing a tooth from its socket.',
                'duration' => '30-60',
                'price' => 100.00,
                'reserve_fee' => 100.00,
                'for_guest' => 1, // Added for_guest value
            ],
            [
                'name' => 'Dental Braces (Consultation and Installation)',
                'description' => 'Initial consultation and installation of braces.',
                'duration' => '60-120',
                'price' => 500.00,
                'reserve_fee' => 500.00,
                'for_guest' => 0, // Not for guests
            ],
            [
                'name' => 'Veneers',
                'description' => 'Thin shells placed over the front of teeth.',
                'duration' => '60-120',
                'price' => 600.00,
                'reserve_fee' => 600.00,
                'for_guest' => 0, // Not for guests
            ],
            [
                'name' => 'Root Canal Treatment',
                'description' => 'Treating the inside of a tooth to save it.',
                'duration' => '60-90',
                'price' => 300.00,
                'reserve_fee' => 300.00,
                'for_guest' => 0, // Not for guests
            ],
            [
                'name' => 'Jacket Crown and Fixed Bridge',
                'description' => 'Crowns and bridges for restoring teeth.',
                'duration' => '60-120',
                'price' => 700.00,
                'reserve_fee' => 700.00,
                'for_guest' => 0, // Not for guests
            ],
            [
                'name' => 'Dentures/Pustiso',
                'description' => 'Fitting and adjustment of dentures.',
                'duration' => '30-60',
                'price' => 400.00,
                'reserve_fee' => 400.00,
                'for_guest' => 0, // Not for guests
            ],
            [
                'name' => 'Wisdom Tooth Removal',
                'description' => 'Surgical removal of wisdom teeth.',
                'duration' => '45-60',
                'price' => 250.00,
                'reserve_fee' => 250.00,
                'for_guest' => 0, // Not for guests
            ],
            [
                'name' => 'Panoramic & Periapical X-ray',
                'description' => 'X-ray imaging for dental assessments.',
                'duration' => '10-15',
                'price' => 75.00,
                'reserve_fee' => 75.00,
                'for_guest' => 1, // Added for_guest value
            ],
        ];

        DB::table('services')->insert($services);
    }
}
