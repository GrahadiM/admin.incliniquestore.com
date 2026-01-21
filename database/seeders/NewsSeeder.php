<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();

        $titles = [
            'Tips Skincare untuk Kulit Berminyak',
            'Manfaat Retinol untuk Anti Aging',
            'Cara Memilih Sunscreen yang Tepat',
            'Skincare Routine Pagi dan Malam',
            'Kandungan Niacinamide dan Fungsinya',
            'Perbedaan Toner dan Essence',
            'Bahaya Over Exfoliating',
            'Urutan Pemakaian Skincare',
            'Kulit Sensitif: Apa yang Harus Dihindari?',
            'Tren Skincare 2026'
        ];

        foreach ($titles as $title) {
            News::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'excerpt' => 'Ini adalah ringkasan singkat dari artikel ' . $title,
                'content' => fake()->paragraph(10),
                'thumbnail' => 'https://source.unsplash.com/600x400/?skincare,beauty',
                'status' => rand(0,1) ? 'published' : 'draft',
                'user_id' => $user->id
            ]);
        }
    }
}
