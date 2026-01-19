<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilities = [
            'mushola',
            'parking',
            'toilet',
            'medical',
            'tribune',
            'security',
            'wifi',
            'shower',
            'gym',
            'locker',
            'canteen',
            'run',
            'sauna',
        ];

        foreach ($facilities as $facility) {
            Facility::create([
                'name' => $facility,
                'photo' => 'icon_' . $facility . '.svg',
            ]);
        }
    }
}
