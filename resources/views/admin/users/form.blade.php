<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->id ?? null ? 'Edit User' : 'Tambah User' }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <form action="{{ $user->id ?? null ? route('super-admin.users.update', $user) : route('super-admin.users.store') }}" method="POST">
                @csrf
                @if(isset($user->id)) @method('PATCH') @endif

                <!-- Name -->
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" class="border rounded w-full px-3 py-2" required>
                </div>

                <!-- Name -->
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $user->whatsapp ?? '') }}" class="border rounded w-full px-3 py-2" required
                        placeholder="Contoh: 6281234567890"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1'); this.setCustomValidity('');"
                        oninvalid="this.setCustomValidity('Nomor WhatsApp wajib diisi.')"
                        maxlength="20"
                    >
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="border rounded w-full px-3 py-2" required>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Password @if(isset($user->id)) <span class="text-red-800">*kosongkan jika tidak perlu diubah!</span>@endif</label>
                    <input type="password" name="password" class="border rounded w-full px-3 py-2" {{ isset($user->id) ? '' : 'required' }}>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Konfirmasi Password  @if(isset($user->id)) <span class="text-red-800">*kosongkan jika tidak perlu diubah!</span>@endif</label>
                    <input type="password" name="password_confirmation" class="border rounded w-full px-3 py-2" {{ isset($user->id) ? '' : 'required' }}>
                </div>

                <!-- Role -->
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Role</label>
                    <select name="role" id="role" class="border rounded w-full px-3 py-2" required>
                        <option value="">-- Pilih Role --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}"
                                @selected(old('role', optional($user)->roles?->pluck('name')->first() ?? '') == $role->name)
                            >
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Branch Store -->
                <div class="mb-4" id="branch-container">
                    <label class="block font-medium text-sm text-gray-700">Branch Store</label>
                    <select name="branch_store_id" class="border rounded w-full px-3 py-2">
                        <option value="">-- Pilih Branch --</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" @selected(old('branch_store_id', $user->branch_store_id ?? '') == $branch->id)>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Member Level -->
                <div class="mb-4" id="member-container">
                    <label class="block font-medium text-sm text-gray-700">Member Level</label>
                    <select name="member_level_id" class="border rounded w-full px-3 py-2">
                        <option value="">-- Pilih Level --</option>
                        @foreach($levels as $level)
                            <option value="{{ $level->id }}" @selected(old('member_level_id', $user->member_level_id ?? '') == $level->id)>{{ $level->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Status</label>
                    <select name="status" class="border rounded w-full px-3 py-2" required>
                        <option value="active" @selected(old('status', $user->status ?? '') == 'active')>Active</option>
                        <option value="inactive" @selected(old('status', $user->status ?? '') == 'inactive')>Inactive</option>
                    </select>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    {{ $user->id ?? null ? 'Update' : 'Simpan' }}
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function toggleFields() {
            const role = document.getElementById('role').value;
            const branch = document.getElementById('branch-container');
            const member = document.getElementById('member-container');

            if (role === 'customer') {
                branch.style.display = 'none';
                member.style.display = 'none';
            } else if (role === 'member') {
                branch.style.display = 'none';
                member.style.display = 'block';
            } else if (role === 'admin') {
                branch.style.display = 'block';
                member.style.display = 'none';
            } else {
                branch.style.display = 'block';
                member.style.display = 'block';
            }
        }

        document.getElementById('role').addEventListener('change', toggleFields);

        // Initial load
        toggleFields();
    </script>
    @endpush
</x-app-layout>
