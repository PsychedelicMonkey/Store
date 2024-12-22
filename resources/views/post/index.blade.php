<x-app-layout>
    <div class="mx-auto max-w-4xl">
        <h1 class="text-3xl font-semibold">{{ __("Posts") }}</h1>

        @if (count($posts) > 0)
            <div class="space-y-6">
                @foreach ($posts as $post)
                    {{-- TODO: style post cards --}}
                    <div>
                        <figure class="aspect-w-3 aspect-h-2">
                            {{ $post->getImage() }}
                        </figure>

                        <h3 class="text-lg font-medium">{{ $post->title }}</h3>

                        <a href="{{ route("post.show", $post) }}">{{ __("Read more") }}</a>
                    </div>
                @endforeach
            </div>

            <div>
                {{ $posts->links() }}
            </div>
        @else
            <h3 class="text-lg font-medium">{{ __("No posts found") }}</h3>
        @endif
    </div>
</x-app-layout>
