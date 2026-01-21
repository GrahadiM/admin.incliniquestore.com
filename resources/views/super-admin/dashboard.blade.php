<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Super Admin Dashboard
        </h2>
    </x-slot>

    <div class="px-2 py-10 max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- ================= MENU PORTAL ================= --}}
        <x-menu-portal />

        {{-- ================= STATISTICS ================= --}}
        <h3 class="text-lg font-semibold mb-4">Management Statistics</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <x-dashboard-card title="Total Users" value="{{ $totalUsers }}" icon="users" color="blue"/>
            <x-dashboard-card title="Total Branches" value="{{ $totalBranches }}" icon="store" color="blue"/>
            <x-dashboard-card title="Total Vouchers" value="{{ $totalVouchers }}" icon="ticket-alt" color="blue"/>
            <x-dashboard-card title="Total Products" value="{{ $totalProducts }}" icon="box" color="blue"/>
            <x-dashboard-card title="Total News" value="{{ $totalNews }}" icon="newspaper" color="blue"/>
            <x-dashboard-card title="Published News" value="{{ $publishedNews }}" icon="check-circle" color="green"/>
            <x-dashboard-card title="Draft News" value="{{ $draftNews }}" icon="file-alt" color="red"/>
            <x-dashboard-card title="News Today" value="{{ $todayNews }}" icon="calendar-day" color="orange"/>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-10">
            {{-- ================= NEWS VIEWS CHART ================= --}}
            <div class="col-span-3 bg-white rounded-lg shadow p-6 mb-10">
                <h3 class="text-lg font-semibold mb-4">News Views Per Day</h3>
                <canvas id="newsChart" height="100"></canvas>
            </div>

            {{-- ================= TOP NEWS ================= --}}
            <div class="bg-white rounded-lg shadow p-6 mb-10">
                <h3 class="text-lg font-semibold mb-4">Top 5 News (By Views)</h3>
                <ul class="space-y-2">
                    @foreach($topNews as $news)
                        <li class="flex justify-between border-b py-2">
                            <span>{{ Str::limit($news->title, 20) }}</span>
                            <span class="font-bold">{{ number_format($news->views) }} views</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('newsChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($viewsPerDay->pluck('date')) !!},
                datasets: [{
                    label: 'Views',
                    data: {!! json_encode($viewsPerDay->pluck('total')) !!},
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: true } },
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>
    @endpush
</x-app-layout>
