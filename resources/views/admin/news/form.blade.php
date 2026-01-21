<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($news) ? 'Edit Berita' : 'Tambah Berita' }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ isset($news) ? route('super-admin.news.update',$news) : route('super-admin.news.store') }}"
                  method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($news)) @method('PATCH') @endif

                <div class="mb-4">
                    <label class="block font-medium">Judul</label>
                    <input type="text" id="title" name="title"
                           value="{{ old('title', $news->title ?? '') }}"
                           class="border rounded w-full px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Slug</label>
                    <input type="text" id="slug" name="slug"
                           value="{{ old('slug', $news->slug ?? '') }}"
                           class="border rounded w-full px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Excerpt</label>
                    <textarea name="excerpt" class="border rounded w-full px-3 py-2">{{ old('excerpt', $news->excerpt ?? '') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Content</label>
                    <textarea name="content" rows="6" class="border rounded w-full px-3 py-2">{{ old('content', $news->content ?? '') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Thumbnail</label>
                    <input type="file" name="thumbnail" onchange="previewThumb(event)">
                    <img id="thumbPreview"
                         src="{{ isset($news) && $news->thumbnail ? asset('storage/'.$news->thumbnail) : '' }}"
                         class="w-32 mt-2 rounded">
                </div>

                <div class="mb-4 flex items-center gap-2">
                    <input type="checkbox" name="is_featured" value="1"
                        @checked(old('is_featured', $news->is_featured ?? false))>
                    <label>Berita Unggulan</label>
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Status</label>
                    <select name="status" class="border rounded w-full px-3 py-2">
                        <option value="active" @selected(old('status', $news->status ?? '')=='active')>Active</option>
                        <option value="inactive" @selected(old('status', $news->status ?? '')=='inactive')>Inactive</option>
                        <option value="draft" @selected(old('status', $news->status ?? '')=='draft')>Draft</option>
                    </select>
                </div>

                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    {{ isset($news) ? 'Update' : 'Simpan' }}
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');
        const originalSlug = slugInput.value;

        function slugify(text) {
            return text.toLowerCase()
                .trim()
                .replace(/\s+/g, '-')
                .replace(/[^\w\-]+/g, '')
                .replace(/\-\-+/g, '-');
        }

        titleInput.addEventListener('input', function () {
            const newSlug = slugify(this.value);
            if (!originalSlug || slugInput.value === originalSlug) {
                slugInput.value = newSlug;
            }
        });

        function previewThumb(e){
            document.getElementById('thumbPreview').src = URL.createObjectURL(e.target.files[0]);
        }
    </script>
    @endpush
</x-app-layout>
