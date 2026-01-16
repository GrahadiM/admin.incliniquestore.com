<?php

namespace Database\Seeders;

use App\Models\BranchStore;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BranchStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            [
                'name' => 'Cabang Jakarta',
                'code' => 'JKT',
                'phone' => '6285767113554',
                'address' => 'Jl. Sudirman No. 1',
                'city' => 'Kota Jakarta',
                'province' => 'DKI Jakarta',
                'country' => 'Indonesia',
                'postal_code' => '10110',
                'latitude' => '-6.200000',
                'longitude' => '106.800000',
            ],
            [
                'name' => 'Cabang Bandung',
                'code' => 'BDG',
                'phone' => '6285767113554',
                'address' => 'Jl. Asia Afrika No. 2',
                'city' => 'Kota Bandung',
                'province' => 'Jawa Barat',
                'country' => 'Indonesia',
                'postal_code' => '40123',
                'latitude' => '-6.900000',
                'longitude' => '107.600000',
            ],
        ];

        foreach ($branches as $branch) {
            BranchStore::updateOrCreate(
                ['code' => $branch['code']],
                $branch
            );
        }
    }
}
