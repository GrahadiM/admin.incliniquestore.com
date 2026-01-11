<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($voucher) ? 'Edit Voucher' : 'Tambah Voucher' }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">

            @if ($errors->any())
                <div class="mb-4 bg-red-100 text-red-800 p-3 rounded">
                    <ul class="list-disc pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ isset($voucher) ? route('super-admin.vouchers.update', $voucher) : route('super-admin.vouchers.store') }}" method="POST">
                @csrf
                @if(isset($voucher)) @method('PATCH') @endif

                <!-- Code -->
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Kode Voucher</label>
                    <input type="text" name="code" value="{{ old('code', $voucher->code ?? '') }}"
                           class="border rounded w-full px-3 py-2" required>
                </div>

                <!-- Name -->
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Nama Voucher</label>
                    <input type="text" name="name" value="{{ old('name', $voucher->name ?? '') }}"
                           class="border rounded w-full px-3 py-2" required>
                </div>

                <!-- Type -->
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Tipe</label>
                    <select name="type" id="type" class="border rounded w-full px-3 py-2" required>
                        <option value="">-- Pilih Tipe --</option>
                        <option value="percent" @selected(old('type', $voucher->type ?? '') == 'percent')>Percent (%)</option>
                        <option value="amount" @selected(old('type', $voucher->type ?? '') == 'amount')>Nominal (Rp)</option>
                    </select>
                </div>

                <!-- Value -->
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Nilai</label>
                    <input type="number" step="0.01" name="value" value="{{ old('value', $voucher->value ?? '') }}"
                           class="border rounded w-full px-3 py-2" required>
                </div>

                <!-- Min Transaction -->
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Minimal Transaksi</label>
                    <input type="number" name="min_transaction"
                           value="{{ old('min_transaction', $voucher->min_transaction ?? 0) }}"
                           class="border rounded w-full px-3 py-2">
                </div>

                <!-- Date -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Start Date</label>
                        <input type="date" name="start_date"
                               value="{{ old('start_date', $voucher->start_date ?? '') }}"
                               class="border rounded w-full px-3 py-2">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">End Date</label>
                        <input type="date" name="end_date"
                               value="{{ old('end_date', $voucher->end_date ?? '') }}"
                               class="border rounded w-full px-3 py-2">
                    </div>
                </div>

                <!-- Quota -->
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Kuota</label>
                    <input type="number" name="quota" value="{{ old('quota', $voucher->quota ?? '') }}"
                           class="border rounded w-full px-3 py-2">
                </div>

                <!-- Branch -->
                <div class="mb-4" id="branch-container">
                    <label class="block font-medium text-sm text-gray-700">Branch Store</label>
                    <select name="branch_store_id" id="branch_store_id" class="border rounded w-full px-3 py-2">
                        <option value="">-- Pilih Branch --</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}"
                                @selected(old('branch_store_id', $voucher->branch_store_id ?? '') == $branch->id)>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Member Level -->
                <div class="mb-4" id="member-container">
                    <label class="block font-medium text-sm text-gray-700">Member Level</label>
                    <select name="member_level_id" id="member_level_id" class="border rounded w-full px-3 py-2">
                        <option value="">-- Pilih Level --</option>
                        @foreach($levels as $level)
                            <option value="{{ $level->id }}"
                                @selected(old('member_level_id', $voucher->member_level_id ?? '') == $level->id)>
                                {{ $level->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Status</label>
                    <select name="status" class="border rounded w-full px-3 py-2" required>
                        <option value="active" @selected(old('status', $voucher->status ?? '') == 'active')>Active</option>
                        <option value="inactive" @selected(old('status', $voucher->status ?? '') == 'inactive')>Inactive</option>
                    </select>
                </div>

                <div class="mt-6 flex justify-between">
                    <a href="{{ route('super-admin.vouchers.index') }}"
                        class="bg-red-700 text-white px-4 py-2 rounded hover:bg-red-800">
                        Kembali
                    </a>

                    <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        {{ isset($voucher) ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            const branchSelect = document.getElementById('branch_store_id');
            const memberSelect = document.getElementById('member_level_id');

            function toggleRelation() {
                if (branchSelect.value) {
                    memberSelect.value = '';
                    memberSelect.disabled = true;
                } else {
                    memberSelect.disabled = false;
                }

                if (memberSelect.value) {
                    branchSelect.value = '';
                    branchSelect.disabled = true;
                } else {
                    branchSelect.disabled = false;
                }
            }

            branchSelect.addEventListener('change', toggleRelation);
            memberSelect.addEventListener('change', toggleRelation);

            toggleRelation();
        </script>
    @endpush
</x-app-layout>
