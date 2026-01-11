<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $level ? 'Edit Member Level' : 'Tambah Member Level' }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <form action="{{ $level ? route('super-admin.member-levels.update', $level) : route('super-admin.member-levels.store') }}" method="POST">
                @csrf
                @if($level) @method('PATCH') @endif

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Level</label>
                    <input type="text" name="name" value="{{ old('name', $level->name ?? '') }}" class="border rounded w-full px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Minimal Points</label>
                    <input type="number" name="min_points" value="{{ old('min_points', $level->min_points ?? 0) }}" class="border rounded w-full px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Minimal Purchase</label>
                    <input type="number" name="min_purchase" value="{{ old('min_purchase', $level->min_purchase ?? 0) }}" class="border rounded w-full px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Minimal Payment</label>
                    <input type="number" name="min_payment" value="{{ old('min_payment', $level->min_payment ?? 0) }}" class="border rounded w-full px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Discount %</label>
                    <input type="number" name="discount_percent" value="{{ old('discount_percent', $level->discount_percent ?? 0) }}" step="0.01" class="border rounded w-full px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" class="border rounded w-full px-3 py-2" required>
                        <option value="active" @selected(old('status', $level->status ?? '') == 'active')>Active</option>
                        <option value="inactive" @selected(old('status', $level->status ?? '') == 'inactive')>Inactive</option>
                    </select>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    {{ $level ? 'Update' : 'Simpan' }}
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
