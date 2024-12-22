<x-app-layout>
    <div class="p-4 lg:p-6">
        <div class="mx-auto max-w-4xl">
            <h1 class="text-3xl font-semibold">{{ __("Posts") }}</h1>

            @if (count($posts) > 0)
                <div class="space-y-6">
                    @foreach ($posts as $post)
                        {{-- TODO: style post cards --}}
                        <div class="border border-gray-300 bg-white">
                            <figure class="aspect-w-3 aspect-h-2">
                                {{ $post->getImage() }}
                            </figure>

                            <div class="px-4 py-2">
                                <h3 class="text-4xl font-semibold text-purple-700">
                                    {{ $post->title }}
                                </h3>

                                <div class="mt-2 flex flex-col justify-between md:flex-row">
                                    <h3 class="text-lg font-medium text-gray-700">
                                        {{ $post->author->name }}
                                    </h3>

                                    <h3 class="text-lg font-medium text-gray-700">
                                        {{ $post->category->name }}
                                    </h3>

                                    <h3 class="text-lg font-medium text-gray-700">
                                        {{ $post->getPublishedDate() }}
                                    </h3>
                                </div>

                                <div class="mb-4 mt-2">
                                    <article class="text-sm">
                                        {{ $post->getShortContent() }}
                                    </article>
                                </div>

                                <a
                                    href="{{ route("post.show", $post) }}"
                                    class="text-purple-700 hover:underline"
                                >
                                    {{ __("Read more") }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $posts->links() }}
                </div>
            @else
                <h3 class="text-lg font-medium">{{ __("No posts found") }}</h3>
            @endif
        </div>
    </div>
</x-app-layout>
