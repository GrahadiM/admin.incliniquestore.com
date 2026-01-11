<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Voucher
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-bold mb-4">{{ $voucher->name }}</h3>

            <div class="grid grid-cols-2 gap-4 mb-2">
                <div class="font-semibold text-gray-700">Kode Voucher</div>
                <div>: {{ $voucher->code }}</div>

                <div class="font-semibold text-gray-700">Tipe</div>
                <div>: {{ ucfirst($voucher->type) }}</div>

                <div class="font-semibold text-gray-700">Nilai Diskon</div>
                <div>
                    :
                    @if ($voucher->type === 'percent')
                        {{ number_format($voucher->value, 0) }}%
                    @else
                        Rp {{ number_format($voucher->value, 0, ',', '.') }}
                    @endif
                </div>

                <div class="font-semibold text-gray-700">Minimal Transaksi</div>
                <div>: Rp {{ number_format($voucher->min_transaction, 0, ',', '.') }}</div>

                <div class="font-semibold text-gray-700">Branch Store</div>
                <div>: {{ $voucher->branchStore?->name ?? '-' }}</div>

                <div class="font-semibold text-gray-700">Member Level</div>
                <div>: {{ $voucher->memberLevel?->name ?? '-' }}</div>

                <div class="font-semibold text-gray-700">Tanggal Mulai</div>
                <div>: {{ $voucher->start_date ?? '-' }}</div>

                <div class="font-semibold text-gray-700">Tanggal Berakhir</div>
                <div>: {{ $voucher->end_date ?? '-' }}</div>

                <div class="font-semibold text-gray-700">Kuota</div>
                <div>: {{ $voucher->quota ?? 'Unlimited' }}</div>

                <div class="font-semibold text-gray-700">Sudah Digunakan</div>
                <div>: {{ $voucher->used }}</div>

                <div class="font-semibold text-gray-700">Status</div>
                <div>: {{ ucfirst($voucher->status) }}</div>
            </div>
        </div>

        <div class="mt-6 flex justify-between">
            <a href="{{ route('super-admin.vouchers.index') }}"
               class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                Kembali
            </a>

            <a href="{{ route('super-admin.vouchers.edit', $voucher->id) }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Edit
            </a>
        </div>
    </div>
</x-app-layout>
