<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Address;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['customer', 'member'];

        foreach ($roles as $role) {
            $users = User::role($role)->get();

            foreach ($users as $user) {
                // Jika user belum punya alamat
                if ($user->addresses()->count() === 0) {
                    $addresses = [
                        [
                            'label' => 'Rumah',
                            'receiver_name' => $user->name,
                            'phone' => $user->whatsapp ?? '6280000000000',
                            'address' => 'Jl. Mawar No. 1',
                            'city' => 'Jakarta',
                            'province' => 'DKI Jakarta',
                            'postal_code' => '10110',
                            'is_default' => true, // otomatis default
                        ],
                        [
                            'label' => 'Kantor',
                            'receiver_name' => $user->name,
                            'phone' => $user->whatsapp ?? '6280000000000',
                            'address' => 'Jl. Melati No. 2',
                            'city' => 'Bandung',
                            'province' => 'Jawa Barat',
                            'postal_code' => '40115',
                            'is_default' => false,
                        ],
                        [
                            'label' => 'Apartemen',
                            'receiver_name' => $user->name,
                            'phone' => $user->whatsapp ?? '6280000000000',
                            'address' => 'Jl. Kenanga No. 3',
                            'city' => 'Surabaya',
                            'province' => 'Jawa Timur',
                            'postal_code' => '60234',
                            'is_default' => false,
                        ],
                    ];

                    foreach ($addresses as $address) {
                        Address::create(array_merge($address, [
                            'user_id' => $user->id,
                        ]));
                    }
                }
            }
        }
    }
}
