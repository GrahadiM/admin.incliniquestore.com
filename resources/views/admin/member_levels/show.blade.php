<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Member Level
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-bold mb-4">{{ $level->id . ' - ' . $level->name }}</h3>

            <div class="grid grid-cols-2 gap-4 mb-2">
                <div class="font-semibold text-gray-700">ID</div>
                <div>: {{ $level->id }}</div>

                <div class="font-semibold text-gray-700">Nama</div>
                <div>: {{ $level->name }}</div>

                <div class="font-semibold text-gray-700">Minimal Points</div>
                <div>: {{ $level->min_points }}</div>

                <div class="font-semibold text-gray-700">Minimal Purchase</div>
                <div>: {{ $level->min_purchase }}</div>

                <div class="font-semibold text-gray-700">Minimal Payment</div>
                <div>: {{ $level->min_payment }}</div>

                <div class="font-semibold text-gray-700">Discount %</div>
                <div>: {{ $level->discount_percent }}%</div>

                <div class="font-semibold text-gray-700">Status</div>
                <div>: {{ ucfirst($level->status) }}</div>

                <div class="font-semibold text-gray-700">Dibuat</div>
                <div>: {{ $level->created_at }}</div>

                <div class="font-semibold text-gray-700">Diperbarui</div>
                <div>: {{ $level->updated_at }}</div>
            </div>
        </div>

        <div class="mt-6 flex justify-between">
            <a href="{{ route('super-admin.member-levels.index') }}" class="bg-red-700 text-white px-4 py-2 rounded hover:bg-red-800">Kembali</a>
            <a href="{{ route('super-admin.member-levels.edit', $level) }}" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800">Edit</a>
        </div>
    </div>
</x-app-layout>
