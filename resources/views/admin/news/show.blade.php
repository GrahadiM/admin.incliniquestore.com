<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Berita
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-xl font-bold mb-4">{{ $news->title }}</h3>

            {{-- <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                <i class="fa fa-eye"></i>
                <span>{{ number_format($news->views) }} views</span>
            </div> --}}

            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="font-semibold">Slug</div><div class="col-span-2">: {{ $news->slug }}</div>
                <div class="font-semibold">Status</div><div class="col-span-2">: {{ ucfirst($news->status) }}</div>
                <div class="font-semibold">Unggulan</div><div class="col-span-2">: {{ $news->is_featured ? 'Yes' : 'No' }}</div>
                <div class="font-semibold">Total Views</div><div class="col-span-2">: {{ $news->views }}</div>
                {{-- <div class="font-semibold">Dibuat Oleh</div><div class="col-span-2">: {{ $news->author->name }}</div>
                <div class="font-semibold">Dibuat Pada</div><div class="col-span-2">: {{ $news->created_at->format('d M Y H:i') }}</div>
                <div class="font-semibold">Terakhir Diperbarui</div><div class="col-span-2">: {{ $news->updated_at->format('d M Y H:i') }}</div> --}}
            </div>

            <div class="mb-4">
                <label class="font-semibold">Thumbnail</label><br>
                @if($news->thumbnail)
                    <img src="{{ asset('storage/'.$news->thumbnail) }}" class="w-64 rounded">
                @endif
            </div>

            <div class="mb-4">
                <label class="font-semibold">Excerpt</label>
                <p class="mt-2">{{ $news->excerpt }}</p>
            </div>

            <div>
                <label class="font-semibold">Content</label>
                <div class="mt-2 prose max-w-none">
                    {!! nl2br(e($news->content)) !!}
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-between">
            <a href="{{ route('super-admin.news.index') }}" class="bg-red-600 text-white px-4 py-2 rounded">Kembali</a>
            <a href="{{ route('super-admin.news.edit',$news) }}" class="bg-blue-600 text-white px-4 py-2 rounded">Edit</a>
        </div>

    </div>

    @push('styles')
        <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "NewsArticle",
                "headline": "{{ $news->title }}",
                "image": ["{{ $news->thumbnail ? asset('storage/'.$news->thumbnail) : asset('logo.png') }}"],
                "author": {
                    "@type": "Person",
                    "name": "{{ $news->author->name ?? 'Admin' }}"
                },
                "publisher": {
                    "@type": "Organization",
                    "name": "{{ config('app.name') }}",
                    "logo": {
                        "@type": "ImageObject",
                        "url": "{{ asset('logo.png') }}"
                    }
                },
                "interactionStatistic": {
                    "@type": "InteractionCounter",
                    "interactionType": "https://schema.org/ViewAction",
                    "userInteractionCount": {{ $news->views }}
                },
                "datePublished": "{{ $news->created_at->toIso8601String() }}",
                "dateModified": "{{ $news->updated_at->toIso8601String() }}"
            }
        </script>
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script>
            function updateViews() {
                fetch("{{ route('news.views.realtime',$news) }}")
                    .then(res => res.json())
                    .then(data => document.getElementById('newsViewsCount').innerText = data.views);
            }
            setInterval(updateViews, 5000);
        </script>
    @endpush
</x-app-layout>
