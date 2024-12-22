<x-app-layout>
    {{-- TODO: style post page --}}
    <div class="mx-auto max-w-7xl">
        <figure>
            {{ $post->getImage() }}
        </figure>

        <h1 class="text-3xl font-semibold">{{ $post->title }}</h1>
        <h3 class="text-lg font-medium">{{ $post->author->name }}</h3>
        <h3 class="text-lg font-medium">{{ $post->category->name }}</h3>
        <h3 class="text-lg font-medium">{{ $post->getPublishedDate() }}</h3>

        <article>
            {!! $post->content !!}
        </article>
    </div>
</x-app-layout>
