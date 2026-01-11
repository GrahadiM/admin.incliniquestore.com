<?php

namespace Database\Seeders;

use App\Models\Voucher;
use App\Models\BranchStore;
use App\Models\MemberLevel;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branch = BranchStore::first();
        $memberLevel = MemberLevel::first();

        $vouchers = [
            [
                'branch_store_id' => $branch?->id,
                'member_level_id' => null,
                'code' => 'BRANCH10',
                'name' => 'Diskon 10% Cabang',
                'type' => 'percent',
                'value' => 10,
                'min_transaction' => 100000,
                'start_date' => now(),
                'end_date' => now()->addMonth(),
                'quota' => 100,
                'used' => 0,
                'status' => 'active',
            ],
            [
                'branch_store_id' => null,
                'member_level_id' => $memberLevel?->id,
                'code' => 'MEMBER50K',
                'name' => 'Diskon Member 50K',
                'type' => 'amount',
                'value' => 50000,
                'min_transaction' => 200000,
                'start_date' => now(),
                'end_date' => now()->addMonths(2),
                'quota' => 50,
                'used' => 0,
                'status' => 'active',
            ],
            [
                'branch_store_id' => null,
                'member_level_id' => null,
                'code' => 'GLOBAL5',
                'name' => 'Voucher Global 5%',
                'type' => 'percent',
                'value' => 5,
                'min_transaction' => 50000,
                'start_date' => now(),
                'end_date' => now()->addMonth(),
                'quota' => null,
                'used' => 0,
                'status' => 'active',
            ],
            [
                'branch_store_id' => $branch?->id,
                'member_level_id' => null,
                'code' => 'CABANG25K',
                'name' => 'Diskon Cabang 25K',
                'type' => 'amount',
                'value' => 25000,
                'min_transaction' => 150000,
                'start_date' => now(),
                'end_date' => now()->addWeeks(3),
                'quota' => 30,
                'used' => 0,
                'status' => 'inactive',
            ],
        ];

        foreach ($vouchers as $voucher) {
            Voucher::create($voucher);
        }
    }
}
