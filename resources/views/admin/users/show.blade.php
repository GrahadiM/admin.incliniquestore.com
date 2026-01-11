<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail User
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-bold mb-4">{{ $user->name }}</h3>

            <div class="grid grid-cols-2 gap-4 mb-2">
                <div class="font-semibold text-gray-700">Email</div>
                <div>: {{ $user->email }}</div>

                <div class="font-semibold text-gray-700">WhatsApp</div>
                <div>: {{ $user->whatsapp ?? '-' }}</div>

                <div class="font-semibold text-gray-700">Gender</div>
                <div>: {{ $user->gender ? ucfirst($user->gender) : '-' }}</div>

                <div class="font-semibold text-gray-700">Status</div>
                <div>: {{ ucfirst($user->status) }}</div>

                <div class="font-semibold text-gray-700">Role</div>
                <div>: {{ $user->roles->pluck('name')->map(fn($r) => ucfirst($r))->join(', ') }}</div>

                <div class="font-semibold text-gray-700">Branch Store</div>
                <div>: {{ $user->branch?->name ?? '-' }}</div>

                <div class="font-semibold text-gray-700">Member Level</div>
                <div>: {{ $user->memberLevel?->name ?? '-' }}</div>
            </div>
        </div>

        <div class="mt-6 flex justify-between">
            <a href="{{ route('super-admin.users.index') }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                Kembali
            </a>
            <a href="http://wa.me/{{ $user->whatsapp }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700" target="_blank" rel="noopener noreferrer">
                Chat
            </a>
        </div>
    </div>
</x-app-layout>
