<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($product) ? 'Edit Product' : 'Tambah Product' }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ isset($product) ? route('super-admin.products.update', $product) : route('super-admin.products.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @if(isset($product)) @method('PATCH') @endif

                <!-- Nama -->
                <div class="mb-4">
                    <label class="block font-medium">Nama Product</label>
                    <input type="text" id="name" name="name"
                           value="{{ old('name', $product->name ?? '') }}"
                           class="border rounded w-full px-3 py-2" required>
                </div>

                <!-- Slug -->
                <div class="mb-4">
                    <label class="block font-medium">Slug</label>
                    <input type="text" id="slug" name="slug"
                           value="{{ old('slug', $product->slug ?? '') }}"
                           class="border rounded w-full px-3 py-2" required>
                </div>

                <!-- Category -->
                <div class="mb-4">
                    <label class="block font-medium">Category</label>
                    <select name="category_id" class="border rounded w-full px-3 py-2" required>
                        <option value="">-- Pilih --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                @selected(old('category_id', $product->category_id ?? '') == $cat->id)>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Harga -->
                <div class="mb-4">
                    <label class="block font-medium">Harga</label>
                    <input type="text" id="price_display"
                           class="border rounded w-full px-3 py-2"
                           placeholder="Rp 0">
                    <input type="hidden" id="price" name="price"
                           value="{{ old('price', $product->price ?? 0) }}">
                </div>

                <!-- Thumbnail -->
                <div class="mb-4">
                    <label class="block font-medium">Thumbnail</label>
                    <input type="file" name="thumbnail" accept="image/*" class="mb-2" onchange="previewThumb(event)">
                    <div>
                        <img id="thumbPreview"
                             src="{{ isset($product) && $product->thumbnail ? asset('storage/'.$product->thumbnail) : '' }}"
                             class="w-32 rounded">
                    </div>
                </div>

                <!-- Gallery -->
                <div class="mb-4">
                    <label class="block font-medium">Gallery Images</label>
                    <input type="file" name="images[]" multiple accept="image/*">
                </div>

                <!-- Unggulan -->
                <div class="mb-4 flex items-center gap-2">
                    <input type="checkbox" name="is_featured" value="1"
                           @checked(old('is_featured', $product->is_featured ?? false))>
                    <label>Product Unggulan</label>
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label class="block font-medium">Status</label>
                    <select name="status" class="border rounded w-full px-3 py-2">
                        <option value="active" @selected(old('status', $product->status ?? '') == 'active')>Active</option>
                        <option value="inactive" @selected(old('status', $product->status ?? '') == 'inactive')>Inactive</option>
                    </select>
                </div>

                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    {{ isset($product) ? 'Update' : 'Simpan' }}
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        const originalSlug = slugInput.value;

        function slugify(text) {
            return text.toLowerCase()
                .trim()
                .replace(/\s+/g, '-')
                .replace(/[^\w\-]+/g, '')
                .replace(/\-\-+/g, '-');
        }

        nameInput.addEventListener('input', function () {
            const newSlug = slugify(this.value);

            if (!originalSlug || slugInput.value === originalSlug) {
                slugInput.value = newSlug;
            }
        });

        const priceDisplay = document.getElementById('price_display');
        const priceInput = document.getElementById('price');

        function formatRupiah(angka) {
            return angka.replace(/\D/g, '')
                .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        priceDisplay.addEventListener('input', function () {
            let clean = this.value.replace(/\./g,'').replace(/\D/g,'');
            this.value = 'Rp ' + formatRupiah(clean);
            priceInput.value = clean;
        });

        // Init harga
        const initialPrice = priceInput.value;
        if(initialPrice){
            priceDisplay.value = 'Rp ' + formatRupiah(initialPrice.toString());
        }

        function previewThumb(e){
            const img = document.getElementById('thumbPreview');
            img.src = URL.createObjectURL(e.target.files[0]);
        }
    </script>
    @endpush
</x-app-layout>
