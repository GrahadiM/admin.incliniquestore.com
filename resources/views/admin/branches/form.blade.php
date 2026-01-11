<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $branch ? 'Edit Branch' : 'Tambah Branch' }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <form action="{{ $branch ? route('super-admin.branches.update', $branch) : route('super-admin.branches.store') }}" method="POST">
            @csrf
            @if($branch) @method('PATCH') @endif

            <div class="bg-white shadow rounded-lg p-6 space-y-4">

                <!-- Name, Code, Phone, Email -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Name</label>
                        <input type="text" name="name" value="{{ old('name', $branch->name ?? '') }}" class="border rounded w-full px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Code</label>
                        <input type="text" name="code" value="{{ old('code', $branch->code ?? '') }}" class="border rounded w-full px-3 py-2" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $branch->phone ?? '') }}" class="border rounded w-full px-3 py-2">
                    </div>
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', $branch->email ?? '') }}" class="border rounded w-full px-3 py-2">
                    </div>
                </div>

                <!-- Latitude & Longitude -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Latitude</label>
                        <input type="text" name="latitude" id="latitude" value="{{ old('latitude', $branch->latitude ?? '') }}" class="border rounded w-full px-3 py-2" readonly>
                    </div>
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Longitude</label>
                        <input type="text" name="longitude" id="longitude" value="{{ old('longitude', $branch->longitude ?? '') }}" class="border rounded w-full px-3 py-2" readonly>
                    </div>
                </div>

                <!-- Address -->
                <div>
                    <label class="block font-medium text-sm text-gray-700">Address</label>
                    <textarea name="address" class="border rounded w-full px-3 py-2">{{ old('address', $branch->address ?? '') }}</textarea>
                </div>

                <!-- City, Province, Country, Postal Code -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="block font-medium text-sm text-gray-700">City</label>
                        <input type="text" name="city" value="{{ old('city', $branch->city ?? '') }}" class="border rounded w-full px-3 py-2">
                    </div>
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Province</label>
                        <input type="text" name="province" value="{{ old('province', $branch->province ?? '') }}" class="border rounded w-full px-3 py-2">
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Country</label>
                        <input type="text" name="country" value="{{ old('country', $branch->country ?? '') }}" class="border rounded w-full px-3 py-2">
                    </div>
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Postal Code</label>
                        <input type="text" name="postal_code" value="{{ old('postal_code', $branch->postal_code ?? '') }}" class="border rounded w-full px-3 py-2">
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label class="block font-medium text-sm text-gray-700">Status</label>
                    <select name="status" class="border rounded w-full px-3 py-2" required>
                        <option value="active" @selected(old('status', $branch->status ?? '')=='active')>Active</option>
                        <option value="inactive" @selected(old('status', $branch->status ?? '')=='inactive')>Inactive</option>
                    </select>
                </div>

                <!-- Google Maps -->
                <div>
                    <label class="block font-medium text-sm text-gray-700 mb-2">Pilih Lokasi di Peta</label>
                    <div id="map" class="w-full h-64 rounded border"></div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    {{ $branch ? 'Update' : 'Simpan' }}
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}"></script>
        <script>
            let map;
            let marker;

            function initMap() {
                const initialLat = parseFloat('{{ old("latitude", $branch->latitude ?? "-6.175392") }}');
                const initialLng = parseFloat('{{ old("longitude", $branch->longitude ?? "106.827153") }}');
                const center = { lat: initialLat, lng: initialLng };

                map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 13,
                    center: center
                });

                marker = new google.maps.Marker({
                    position: center,
                    map: map,
                    draggable: true
                });

                // Update lat/lng input saat marker digeser
                google.maps.event.addListener(marker, 'dragend', function() {
                    document.getElementById('latitude').value = marker.getPosition().lat();
                    document.getElementById('longitude').value = marker.getPosition().lng();
                });

                // Klik peta untuk pindahkan marker
                map.addListener('click', function(e) {
                    marker.setPosition(e.latLng);
                    document.getElementById('latitude').value = e.latLng.lat();
                    document.getElementById('longitude').value = e.latLng.lng();
                });
            }

            window.onload = initMap;
        </script>
    @endpush
</x-app-layout>
