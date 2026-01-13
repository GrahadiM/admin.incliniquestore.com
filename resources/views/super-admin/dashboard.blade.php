<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Super Admin Dashboard
        </h2>
    </x-slot>

    <div class="px-2 py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ================= STATISTICS ================= --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Users</p>
                            <h3 class="text-2xl font-bold">{{ $totalUsers }}</h3>
                        </div>
                        <i class="fas fa-users text-3xl text-blue-600"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Branches</p>
                            <h3 class="text-2xl font-bold">{{ $totalBranches }}</h3>
                        </div>
                        <i class="fas fa-store text-3xl text-green-600"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Products</p>
                            <h3 class="text-2xl font-bold">{{ $totalProducts }}</h3>
                        </div>
                        <i class="fas fa-box text-3xl text-purple-600"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-orange-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Vouchers</p>
                            <h3 class="text-2xl font-bold">{{ $totalVouchers }}</h3>
                        </div>
                        <i class="fas fa-ticket-alt text-3xl text-orange-600"></i>
                    </div>
                </div>

            </div>


            {{-- ================= MENU PORTAL ================= --}}
            <h3 class="text-lg font-semibold mb-4">Management Portal</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                @php
                    $menus = [
                        ['title' => 'Users', 'icon' => 'fa-users', 'color' => 'blue', 'route' => 'super-admin.users.index'],
                        ['title' => 'Branches', 'icon' => 'fa-store', 'color' => 'green', 'route' => 'super-admin.branches.index'],
                        ['title' => 'Member Levels', 'icon' => 'fa-layer-group', 'color' => 'purple', 'route' => 'super-admin.member-levels.index'],
                        ['title' => 'Vouchers', 'icon' => 'fa-ticket-alt', 'color' => 'orange', 'route' => 'super-admin.vouchers.index'],
                        ['title' => 'Categories', 'icon' => 'fa-tags', 'color' => 'blue', 'route' => 'super-admin.categories.index'],
                        ['title' => 'Products', 'icon' => 'fa-box', 'color' => 'green', 'route' => 'super-admin.products.index'],
                    ];
                @endphp

                @foreach($menus as $menu)
                    <a href="{{ route($menu['route']) }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition border-t-4 border-{{ $menu['color'] }}-600">
                        <div class="flex flex-col items-center text-center space-y-3">
                            <i class="fas {{ $menu['icon'] }} text-4xl text-{{ $menu['color'] }}-600"></i>
                            <h4 class="font-semibold">{{ $menu['title'] }}</h4>
                        </div>
                    </a>
                @endforeach

            </div>

        </div>
    </div>
</x-app-layout>
