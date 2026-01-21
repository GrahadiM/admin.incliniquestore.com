<div>
    <h3 class="text-lg font-semibold mb-4">Management Portal</h3>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 mb-10">
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
