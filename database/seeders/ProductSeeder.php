<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::first();

        $products = [
            [
                'name' => 'Hydrating Facial Cleanser',
                'price' => 85000,
                'is_featured' => true,
                'thumbnail' => 'products/thumbnail.webp',
                'gallery' => [
                    'products/gallery/gallery-1.webp',
                    'products/gallery/gallery-2.webp'
                ]
            ],
            [
                'name' => 'Vitamin C Brightening Serum',
                'price' => 120000,
                'is_featured' => true,
                'thumbnail' => 'products/thumbnail.webp',
                'gallery' => [
                    'products/gallery/gallery-1.webp',
                    'products/gallery/gallery-2.webp'
                ]
            ],
            [
                'name' => 'Niacinamide + Zinc Serum',
                'price' => 99000,
                'is_featured' => false,
                'thumbnail' => 'products/thumbnail.webp',
                'gallery' => [
                    'products/gallery/gallery-1.webp',
                    'products/gallery/gallery-2.webp'
                ]
            ],
            [
                'name' => 'Aloe Vera Soothing Gel',
                'price' => 65000,
                'is_featured' => false,
                'thumbnail' => 'products/thumbnail.webp',
                'gallery' => [
                    'products/gallery/gallery-1.webp',
                    'products/gallery/gallery-2.webp'
                ]
            ],
            [
                'name' => 'Sunscreen SPF 50+ PA++++',
                'price' => 110000,
                'is_featured' => true,
                'thumbnail' => 'products/thumbnail.webp',
                'gallery' => [
                    'products/gallery/gallery-1.webp',
                    'products/gallery/gallery-2.webp'
                ]
            ]
        ];

        foreach ($products as $item) {
            $product = Product::create([
                'category_id' => $category->id,
                'name'        => $item['name'],
                'slug'        => Str::slug($item['name']),
                'price'       => $item['price'],
                'thumbnail'   => $item['thumbnail'],
                'is_featured' => $item['is_featured'],
                'status'      => 'active'
            ]);

            foreach ($item['gallery'] as $img) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $img
                ]);
            }
        }
    }
}
