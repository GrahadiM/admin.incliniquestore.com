<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">News Analytics</h2>
    </x-slot>

    <div class="px-2 py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between mb-4">
            <h2 class="text-xl font-bold">News Analytics</h2>
            <div class="flex gap-2">
                <a href="{{ route('super-admin.news.index') }}" class="bg-red-600 text-white px-4 py-2 rounded">
                    Back to News
                </a>
            </div>
        </div>

        <!-- Filter -->
        <form method="GET" class="flex gap-2 mb-4">
            <input type="date" name="start_date" value="{{ $startDate }}" class="border rounded px-2 py-1">
            <input type="date" name="end_date" value="{{ $endDate }}" class="border rounded px-2 py-1">
            <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded">Filter</button>
        </form>

        <!-- Views Per News -->
        <div class="bg-white shadow rounded p-4 mb-6">
            <h3 class="font-bold mb-2">Top News</h3>
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b">
                        <th class="p-2">Title</th>
                        <th class="p-2">Views</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($newsViews as $news)
                        <tr class="border-b">
                            <td class="p-2">{{ $news->title }}</td>
                            <td class="p-2">{{ $news->views_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Daily Views Line Chart -->
        <div class="bg-white shadow rounded p-4 mb-6">
            <h3 class="font-bold mb-2">Daily Views</h3>
            <canvas id="dailyViewsChart" height="100"></canvas>
        </div>

        <!-- Heatmap -->
        <div class="bg-white shadow rounded p-4">
            <h3 class="font-bold mb-2">Hourly Heatmap (Views per Hour)</h3>
            <div class="grid grid-cols-24 gap-1">
                @foreach(range(0,23) as $h)
                    @php
                        $count = $hourlyHeat->firstWhere('hour', $h)->total ?? 0;
                        $colorIntensity = min(255, $count * 10);
                    @endphp
                    <div class="h-10 w-full rounded"
                         style="background-color: rgba(255,0,0, {{ $colorIntensity/255 }})"
                         title="{{ $h }}:00 - {{ $count }} views">
                        {{ $h }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('dailyViewsChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($dailyViews->pluck('view_date')) !!},
                    datasets: [{
                        label: 'Views',
                        data: {!! json_encode($dailyViews->pluck('total')) !!},
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: true }
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>
