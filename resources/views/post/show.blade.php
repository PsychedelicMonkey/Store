<x-app-layout>
    {{-- TODO: style post page --}}
    <div class="p-4 lg:p-6">
        <div class="mx-auto max-w-7xl">
            <div class="grid gap-4 lg:grid-cols-3">
                <div class="col-span-2">
                    <div class="space-y-4">
                        <!-- Post Header -->
                        <header class="border border-gray-300 bg-white">
                            <figure class="aspect-w-3 aspect-h-2">
                                {{ $post->getImage() }}
                            </figure>

                            <div class="px-6 py-4">
                                <h1 class="text-3xl font-semibold">{{ $post->title }}</h1>

                                <h3 class="text-lg font-medium">{{ $post->author->name }}</h3>

                                <h3 class="text-lg font-medium">{{ $post->category->name }}</h3>

                                <h3 class="text-lg font-medium">
                                    {{ $post->getPublishedDate() }}
                                </h3>
                            </div>
                        </header>

                        <!-- Article content -->
                        <article class="prose max-w-none border border-gray-300 bg-white p-6">
                            {!! $post->content !!}
                        </article>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-span-2 lg:col-span-1">
                    <div class="space-y-4">
                        <!-- Author -->
                        <div class="border border-gray-300 bg-white p-4">
                            <header
                                class="mb-4 flex flex-col items-center justify-center text-center"
                            >
                                @if ($post->author->user)
                                    <div
                                        class="h-44 w-44 overflow-hidden rounded-full border border-black"
                                    >
                                        <figure>
                                            {{ $post->author->user?->getAvatar() }}
                                        </figure>
                                    </div>
                                @endif

                                <div class="mt-2">
                                    <h1 class="text-lg font-semibold text-purple-700">
                                        {{ $post->author->name }}
                                    </h1>

                                    <h3 class="text-sm font-medium text-gray-700">
                                        {{ $post->author->email }}
                                    </h3>
                                </div>
                            </header>

                            <article class="prose prose-sm max-w-none">
                                {!! $post->author->bio !!}}
                            </article>
                        </div>

                        @if (count($post->tags) > 0)
                            <!-- Tags -->
                            <div class="flex flex-wrap gap-2">
                                @foreach ($post->tags as $tag)
                                    {{-- TODO: add tag link --}}
                                    <a href="#" class="rounded-lg bg-gray-300 px-2 py-1 text-sm">
                                        {{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Comments -->
            <section>
                <h1>{{ __("Comments") }}</h1>
                {{-- TODO: Add comments section --}}
            </section>
        </div>
    </div>
</x-app-layout>
