<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Branch') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-bold mb-4">{{ $branch->code . ' - ' . $branch->name }}</h3>

            <div class="grid grid-cols-2 gap-4 mb-2">
                <div class="font-semibold text-gray-700">ID</div>
                <div>: {{ $branch->id }}</div>

                <div class="font-semibold text-gray-700">Code</div>
                <div>: {{ $branch->code }}</div>

                <div class="font-semibold text-gray-700">Name</div>
                <div>: {{ $branch->name }}</div>

                <div class="font-semibold text-gray-700">Phone</div>
                <div>: {{ $branch->phone ?? '-' }}</div>

                <div class="font-semibold text-gray-700">Email</div>
                <div>: {{ $branch->email ?? '-' }}</div>

                <div class="font-semibold text-gray-700">Latitude</div>
                <div>: {{ $branch->latitude ?? '-' }}</div>

                <div class="font-semibold text-gray-700">Longitude</div>
                <div>: {{ $branch->longitude ?? '-' }}</div>

                <div class="font-semibold text-gray-700">City</div>
                <div>: {{ $branch->city ?? '-' }}</div>

                <div class="font-semibold text-gray-700">Province</div>
                <div>: {{ $branch->province ?? '-' }}</div>

                <div class="font-semibold text-gray-700">Country</div>
                <div>: {{ $branch->country ?? '-' }}</div>

                <div class="font-semibold text-gray-700">Postal Code</div>
                <div>: {{ $branch->postal_code ?? '-' }}</div>

                <div class="font-semibold text-gray-700">Address</div>
                <div>: {{ $branch->address ?? '-' }}</div>

                <div class="font-semibold text-gray-700">Status</div>
                <div>: {{ ucfirst($branch->status) }}</div>
            </div>
        </div>

        @if($branch->latitude && $branch->longitude)
            <div class="bg-white shadow rounded-lg p-6">
                <h4 class="text-lg font-semibold mb-2">Lokasi Branch</h4>
                <div id="map" class="w-full h-64 rounded border"></div>
            </div>
        @endif

        <div class="mt-6 flex justify-between">
            <a href="{{ route('super-admin.branches.index') }}" class="inline-block bg-red-700 text-white px-4 py-2 rounded hover:bg-red-800">
                Kembali
            </a>

            @if($branch->latitude && $branch->longitude)
                <a href="https://www.google.com/maps?q={{ $branch->latitude }},{{ $branch->longitude }}" target="_blank" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Lihat di Google Maps
                </a>
            @endif
        </div>
    </div>

    @push('scripts')
        @if($branch->latitude && $branch->longitude)
            <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}"></script>
            <script>
                function initMap() {
                    const branchLocation = {
                        lat: parseFloat('{{ $branch->latitude }}'),
                        lng: parseFloat('{{ $branch->longitude }}')
                    };

                    const map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 15,
                        center: branchLocation
                    });

                    new google.maps.Marker({
                        position: branchLocation,
                        map: map,
                        title: '{{ $branch->name }}'
                    });
                }

                window.onload = initMap;
            </script>
        @endif
    @endpush
</x-app-layout>
