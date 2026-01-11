<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\BranchStore;
use App\Models\MemberLevel;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use function Symfony\Component\Clock\now;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jakartaBranch = BranchStore::where('code', 'JKT')->first();
        $bandungBranch = BranchStore::where('code', 'BDG')->first();
        $copperLevel = MemberLevel::where('name', 'Copper')->first();

        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => Hash::make('password'),
                'whatsapp' => '6285767113554',
                'gender' => 'male',
                'role' => 'super-admin',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Admin Jakarta',
                'email' => 'admin.jkt@example.com',
                'password' => Hash::make('password'),
                'whatsapp' => '6285767113554',
                'gender' => 'male',
                'branch_store_id' => $jakartaBranch?->id,
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Admin Bandung',
                'email' => 'admin.bdg@example.com',
                'password' => Hash::make('password'),
                'whatsapp' => '6285767113554',
                'gender' => 'male',
                'branch_store_id' => $bandungBranch?->id,
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Member User',
                'email' => 'member@example.com',
                'password' => Hash::make('password'),
                'whatsapp' => '6285767113554',
                'gender' => 'male',
                'member_level_id' => $copperLevel?->id,
                'role' => 'member',
            ],
            [
                'name' => 'Customer User',
                'email' => 'customer@example.com',
                'password' => Hash::make('password'),
                'whatsapp' => '6285767113554',
                'gender' => 'male',
                'role' => 'customer',
            ],
        ];

        foreach ($users as $data) {
            $role = $data['role'];
            unset($data['role']);

            $user = User::updateOrCreate(
                ['email' => $data['email']],
                $data
            );

            $user->assignRole($role);
        }
    }
}
