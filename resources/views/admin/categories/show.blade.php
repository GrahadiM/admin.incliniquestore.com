<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Category
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-bold mb-4">
                {{ $category->id . ' - ' . $category->name }}
            </h3>

            <div class="grid grid-cols-2 gap-4 mb-2">
                <div class="font-semibold text-gray-700">ID</div>
                <div>: {{ $category->id }}</div>

                <div class="font-semibold text-gray-700">Nama</div>
                <div>: {{ $category->name }}</div>

                <div class="font-semibold text-gray-700">Slug</div>
                <div>: {{ $category->slug }}</div>

                <div class="font-semibold text-gray-700">Status</div>
                <div>: {{ ucfirst($category->status) }}</div>

                <div class="font-semibold text-gray-700">Dibuat</div>
                <div>: {{ $category->created_at }}</div>

                <div class="font-semibold text-gray-700">Diperbarui</div>
                <div>: {{ $category->updated_at }}</div>
            </div>
        </div>

        <div class="mt-6 flex justify-between">
            <a href="{{ route('super-admin.categories.index') }}"
               class="bg-red-700 text-white px-4 py-2 rounded hover:bg-red-800">
                Kembali
            </a>

            <a href="{{ route('super-admin.categories.edit', $category) }}"
               class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800">
                Edit
            </a>
        </div>
    </div>
</x-app-layout>
