<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            BranchStoreSeeder::class,
            MemberLevelSeeder::class,
            UserSeeder::class,
            AddressSeeder::class,
            VoucherSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
