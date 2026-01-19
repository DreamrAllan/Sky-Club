<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Review;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        
        // Create articles with real content
        $articles = [
            [
                'title' => 'Tips Meningkatkan Skill Mini Soccer untuk Pemula',
                'content' => '<p>Mini soccer atau futsal adalah olahraga yang membutuhkan kombinasi antara kecepatan, ketepatan, dan kerja sama tim. Berikut adalah beberapa tips untuk meningkatkan skill Anda:</p>
                <h3>1. Latihan Kontrol Bola</h3>
                <p>Kontrol bola adalah fundamental dalam mini soccer. Lakukan latihan juggling dan dribbling setiap hari minimal 15 menit.</p>
                <h3>2. Passing Akurat</h3>
                <p>Passing yang akurat sangat penting dalam lapangan kecil. Latih passing pendek dengan partner secara rutin.</p>
                <h3>3. Positioning</h3>
                <p>Pahami posisi Anda di lapangan dan selalu aware dengan pergerakan tim lawan.</p>',
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Panduan Memilih Sepatu Futsal yang Tepat',
                'content' => '<p>Sepatu futsal yang tepat dapat meningkatkan performa Anda di lapangan. Berikut panduan memilihnya:</p>
                <h3>Jenis Sol</h3>
                <p>Pilih sol karet dengan grip yang baik untuk lapangan indoor.</p>
                <h3>Material Upper</h3>
                <p>Leather memberikan kontrol bola lebih baik, synthetic lebih ringan dan tahan air.</p>
                <h3>Fit dan Comfort</h3>
                <p>Pastikan sepatu pas di kaki, tidak terlalu sempit atau longgar.</p>',
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Manfaat Bermain Mini Soccer untuk Kesehatan',
                'content' => '<p>Bermain mini soccer secara rutin memberikan banyak manfaat kesehatan:</p>
                <h3>Kardiovaskular</h3>
                <p>Meningkatkan kesehatan jantung dan stamina tubuh.</p>
                <h3>Pembakaran Kalori</h3>
                <p>Dalam satu jam bermain, Anda bisa membakar 400-600 kalori.</p>
                <h3>Kesehatan Mental</h3>
                <p>Mengurangi stress dan meningkatkan mood melalui aktivitas fisik dan interaksi sosial.</p>',
                'created_by' => $admin->id,
            ],
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }

        // Create reviews
        $users = User::where('role', 'penyewa')->get();
        $bookings = Booking::where('status', 'accept')->take(5)->get();
        
        $reviewComments = [
            'Lapangan sangat bagus dan terawat! Rumput sintetis berkualitas tinggi. Pasti akan booking lagi.',
            'Fasilitas lengkap, ada ruang ganti dan kamar mandi bersih. Lokasi strategis dan mudah dijangkau.',
            'Pelayanan ramah dan profesional. Harga terjangkau untuk kualitas lapangan yang premium.',
            'Pengalaman bermain yang menyenangkan. Pencahayaan bagus untuk main malam hari.',
            'Booking online mudah dan cepat. Staff sangat membantu. Highly recommended!',
        ];

        $profilePhotos = [
            'images/profiles/user_1.jpg',
            'images/profiles/user_2.jpg', 
            'images/profiles/user_3.jpg',
        ];

        foreach ($users as $index => $user) {
            // Update user profile photo
            $user->update([
                'profile_photo' => $profilePhotos[$index % 3],
                'team' => ['Garuda FC', 'Elang United', 'Rajawali Sport', 'Phoenix Team', 'Dragon FC'][$index % 5],
            ]);

            if (isset($bookings[$index])) {
                Review::create([
                    'id_user' => $user->id,
                    'id_booking' => $bookings[$index]->id,
                    'rating' => rand(4, 5),
                    'comment' => $reviewComments[$index % count($reviewComments)],
                ]);
            }
        }
    }
}
