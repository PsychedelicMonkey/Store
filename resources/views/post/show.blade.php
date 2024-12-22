<x-app-layout>
    {{-- TODO: style post page --}}
    <div class="p-4 lg:p-6">
        <div class="mx-auto max-w-7xl">
            <header class="max-w-2xl">
                <figure class="aspect-w-3 aspect-h-2">
                    {{ $post->getImage() }}
                </figure>

                <h1 class="text-3xl font-semibold">{{ $post->title }}</h1>
                <h3 class="text-lg font-medium">{{ $post->author->name }}</h3>
                <h3 class="text-lg font-medium">{{ $post->category->name }}</h3>
                <h3 class="text-lg font-medium">{{ $post->getPublishedDate() }}</h3>
            </header>

            <article class="prose">
                {!! $post->content !!}
            </article>
        </div>

        <section>
            {{-- TODO: Add comments section --}}
        </section>
    </div>
</x-app-layout>
