<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <form action="{{ route('super-admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PATCH')

                {{-- Nama --}}
                <div class="mb-4">
                    <label for="name" class="block font-medium text-gray-700">Nama</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="block font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                {{-- WhatsApp --}}
                <div class="mb-4">
                    <label for="whatsapp" class="block font-medium text-gray-700">WhatsApp</label>
                    <input type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                {{-- Gender --}}
                <div class="mb-4">
                    <label for="gender" class="block font-medium text-gray-700">Gender</label>
                    <select name="gender" id="gender" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Pilih Gender --</option>
                        <option value="male" {{ old('gender', $user->gender)=='male' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="female" {{ old('gender', $user->gender)=='female' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                {{-- Role --}}
                <div class="mb-4">
                    <label for="role" class="block font-medium text-gray-700">Role</label>
                    <select name="role" id="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ ($user->roles->pluck('name')->contains($role->name)) ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Branch --}}
                <div class="mb-4">
                    <label for="branch_store_id" class="block font-medium text-gray-700">Branch Store</label>
                    <select name="branch_store_id" id="branch_store_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Pilih Branch --</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ old('branch_store_id', $user->branch_store_id)==$branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Member Level --}}
                <div class="mb-4">
                    <label for="member_level_id" class="block font-medium text-gray-700">Member Level</label>
                    <select name="member_level_id" id="member_level_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Pilih Level --</option>
                        @foreach($levels as $level)
                            <option value="{{ $level->id }}" {{ old('member_level_id', $user->member_level_id)==$level->id ? 'selected' : '' }}>
                                {{ $level->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <label for="password" class="block font-medium text-gray-700">Password <small class="text-gray-500">(Kosongkan jika tidak ingin diubah)</small></label>
                    <input type="password" name="password" id="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                {{-- Submit --}}
                <div class="flex justify-end">
                    <a href="{{ route('super-admin.users.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500 mr-2">
                        Batal
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
