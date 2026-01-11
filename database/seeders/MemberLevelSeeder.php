<?php

namespace Database\Seeders;

use App\Models\MemberLevel;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MemberLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            [
                'name' => 'Copper',
                'min_points' => 0,
                'min_purchase' => 0,
                'min_payment' => 0,
                'discount_percent' => 0,
            ],
            [
                'name' => 'Silver',
                'min_points' => 50,
                'min_purchase' => 10,
                'min_payment' => 500000,
                'discount_percent' => 5,
            ],
            [
                'name' => 'Gold',
                'min_points' => 500,
                'min_purchase' => 100,
                'min_payment' => 5000000,
                'discount_percent' => 10,
            ],
            [
                'name' => 'Platinum',
                'min_points' => 5000,
                'min_purchase' => 1000,
                'min_payment' => 50000000,
                'discount_percent' => 15,
            ],
            [
                'name' => 'Diamond',
                'min_points' => 100000,
                'min_purchase' => 10000,
                'min_payment' => 1000000000,
                'discount_percent' => 20,
            ],
            [
                'name' => 'Master',
                'min_points' => 1000000,
                'min_purchase' => 100000,
                'min_payment' => 10000000000,
                'discount_percent' => 25,
            ],
        ];

        foreach ($levels as $level) {
            MemberLevel::updateOrCreate(
                ['name' => $level['name']],
                $level
            );
        }
    }
}
