<x-app-layout>
    <div class="max-w-4xl mx-auto py-8">
        <h1 class="text-3xl font-bold">{{ $news->title }}</h1>
        <img src="{{ asset('storage/'.$news->thumbnail) }}" class="rounded my-4">
        <div class="prose max-w-none">
            {!! $news->content !!}
        </div>
    </div>
</x-app-layout>
