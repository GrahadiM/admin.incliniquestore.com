<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($category) ? 'Edit Category' : 'Tambah Category' }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <form action="{{ isset($category) ? route('super-admin.categories.update', $category) : route('super-admin.categories.store') }}"
                  method="POST">
                @csrf
                @if(isset($category)) @method('PATCH') @endif

                <!-- Nama -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Category</label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $category->name ?? '') }}"
                           class="border rounded w-full px-3 py-2"
                           required>
                </div>

                <!-- Slug -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Slug</label>
                    <input type="text"
                           id="slug"
                           name="slug"
                           value="{{ old('slug', $category->slug ?? '') }}"
                           class="border rounded w-full px-3 py-2"
                           placeholder="contoh: makanan-ringan"
                           required>
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" class="border rounded w-full px-3 py-2" required>
                        <option value="active" @selected(old('status', $category->status ?? '') == 'active')>
                            Active
                        </option>
                        <option value="inactive" @selected(old('status', $category->status ?? '') == 'inactive')>
                            Inactive
                        </option>
                    </select>
                </div>

                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    {{ isset($category) ? 'Update' : 'Simpan' }}
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');

            // Flag untuk mendeteksi apakah user mengubah slug secara manual
            let isManualSlug = false;

            // Simpan nilai awal slug
            const initialSlug = slugInput.value;

            function slugify(text) {
                return text
                    .toString()
                    .toLowerCase()
                    .trim()
                    .replace(/\s+/g, '-')       // ganti spasi dengan -
                    .replace(/[^\w\-]+/g, '')   // hapus karakter aneh
                    .replace(/\-\-+/g, '-');    // hapus double -
            }

            // Event: user mengetik di field name
            nameInput.addEventListener('input', function () {
                // Jika slug belum diubah manual, update slug otomatis
                if (!isManualSlug) {
                    slugInput.value = slugify(this.value);
                }
            });

            // Event: user mengetik di field slug → set flag manual
            slugInput.addEventListener('input', function () {
                // Jika user mengetik, slug dianggap manual
                isManualSlug = this.value !== slugify(nameInput.value);
            });

            // Optional: reset flag jika slug sama persis dengan auto-slug
            slugInput.addEventListener('blur', function () {
                if (this.value === slugify(nameInput.value)) {
                    isManualSlug = false;
                }
            });
        </script>
    @endpush
</x-app-layout>
