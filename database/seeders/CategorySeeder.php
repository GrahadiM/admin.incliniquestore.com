<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Cleanser',
            'Facial Wash',
            'Toner',
            'Essence',
            'Serum',
            'Ampoule',
            'Moisturizer',
            'Day Cream',
            'Night Cream',
            'Eye Cream',
            'Sunscreen',
            'Exfoliator',
            'Peeling Gel',
            'Clay Mask',
            'Sheet Mask',
            'Sleeping Mask',
            'Face Oil',
            'Spot Treatment',
            'Acne Care',
            'Brightening',
            'Anti Aging',
            'Hydrating',
            'Whitening',
            'Soothing',
            'Sensitive Skin',
            'Oily Skin',
            'Dry Skin',
            'Combination Skin',
            'Lip Care',
            'Body Care'
        ];

        foreach ($categories as $name) {
            Category::create([
                'name'   => $name,
                'slug'   => Str::slug($name),
                'status' => 'active',
            ]);
        }
    }
}
