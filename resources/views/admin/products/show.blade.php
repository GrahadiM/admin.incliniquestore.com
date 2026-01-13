<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Product
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-xl font-bold mb-4">{{ $product->name }}</h3>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>Slug</div><div>: {{ $product->slug }}</div>
                <div>Category</div><div>: {{ $product->category?->name }}</div>
                <div>Harga</div><div>: Rp{{ number_format($product->price,0,',','.') }}</div>
                <div>Status</div><div>: {{ ucfirst($product->status) }}</div>
                <div>Unggulan</div><div>: {{ $product->is_featured ? 'Yes' : 'No' }}</div>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Thumbnail</label><br>
                @if($product->thumbnail)
                    <img src="{{ Str::startsWith($product->thumbnail, 'http') ? $product->thumbnail : asset('storage/'.$product->thumbnail) }}">
                @endif
            </div>

            <div>
                <label class="font-semibold">Gallery</label>
                <div class="grid grid-cols-2 gap-3 mt-2">
                    @foreach($product->images as $img)
                        <img src="{{ Str::startsWith($img->image_path, 'http') ? $img->image_path : asset('storage/'.$img->image_path) }}">
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-between">
            <a href="{{ route('super-admin.products.index') }}" class="bg-red-600 text-white px-4 py-2 rounded">Kembali</a>
            <a href="{{ route('super-admin.products.edit', $product) }}" class="bg-blue-600 text-white px-4 py-2 rounded">Edit</a>
        </div>
    </div>
</x-app-layout>
