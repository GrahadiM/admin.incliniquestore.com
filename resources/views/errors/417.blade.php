<x-error-layout>
    <div class="text-center py-10">
        <h1 class="text-6xl font-bold text-red-500">417</h1>
        <p class="text-xl mt-4 text-gray-700">
            Harapan request tidak dapat dipenuhi.
        </p>
        <a href="{{ url('/') }}"
           class="mt-6 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            Kembali ke Beranda
        </a>
    </div>
</x-error-layout>
