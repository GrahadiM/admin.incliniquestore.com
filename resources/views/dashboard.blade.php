<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    @push('styles')
    <style>
        .portal-link {
            display: block;
            padding: 8px 12px;
            border-radius: 6px;
            color: #374151;
            transition: all 0.2s ease;
        }

        .portal-link:hover {
            background-color: #f3f4f6;
            padding-left: 16px;
        }
    </style>
    @endpush

    <div class="px-2 py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- ================= SUPER ADMIN PORTAL ================= --}}
                @role('super-admin')
                <div class="bg-white shadow rounded-lg p-6 border-t-4 border-red-600">
                    <h3 class="text-lg font-semibold mb-4 text-red-600">
                        Super Admin Portal
                    </h3>

                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('super-admin.dashboard') }}" class="portal-link">Dashboard</a></li>
                        <li><a href="{{ route('super-admin.users.index') }}" class="portal-link">Manage Users</a></li>
                        <li><a href="{{ route('super-admin.branches.index') }}" class="portal-link">Manage Branches</a></li>
                        <li><a href="{{ route('super-admin.member-levels.index') }}" class="portal-link">Member Levels</a></li>
                        <li><a href="{{ route('super-admin.vouchers.index') }}" class="portal-link">Vouchers</a></li>
                        <li><a href="{{ route('super-admin.categories.index') }}" class="portal-link">Categories</a></li>
                        <li><a href="{{ route('super-admin.products.index') }}" class="portal-link">Products</a></li>
                    </ul>
                </div>
                @endrole


                {{-- ================= ADMIN PORTAL ================= --}}
                @role('admin')
                <div class="bg-white shadow rounded-lg p-6 border-t-4 border-blue-600">
                    <h3 class="text-lg font-semibold mb-4 text-blue-600">
                        Admin Portal
                    </h3>

                    <ul class="space-y-2 text-sm">
                        <li><a href="/admin" class="portal-link">Admin Dashboard</a></li>
                        <li><a href="{{ route('profile.edit') }}" class="portal-link">My Profile</a></li>
                    </ul>
                </div>
                @endrole


                {{-- ================= COMMON PORTAL ================= --}}
                @hasanyrole('admin|super-admin')
                <div class="bg-white shadow rounded-lg p-6 border-t-4 border-gray-600">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700">
                        General
                    </h3>

                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('profile.edit') }}" class="portal-link">Edit Profile</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="portal-link text-left w-full text-red-600">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                @endhasanyrole

            </div>
        </div>
    </div>
</x-app-layout>
