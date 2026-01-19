<?php

namespace Database\Seeders;

use App\Models\Photo;
use Illuminate\Database\Seeder;

class PhotoSeeder extends Seeder
{
    public function run(): void
    {
        $photos = [
            ['id_field' => 1, 'photo' => 'field_1.jpg', 'title' => 'Lapangan Utama'],
            ['id_field' => 1, 'photo' => 'field_2.jpg', 'title' => 'Lapangan Premium'],
            ['id_field' => 1, 'photo' => 'field_3.jpg', 'title' => 'Lapangan Indoor'],
        ];

        foreach ($photos as $photo) {
            Photo::create($photo);
        }
    }
}
