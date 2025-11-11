<x-layouts.public>
    <article class="bg-white py-12 dark:bg-zinc-900">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <!-- Back Link -->
            <div class="mb-8">
                <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Blog
                </a>
            </div>

            <!-- Post Header -->
            <header class="mb-8">
                <div class="mb-4 flex flex-wrap gap-2">
                    @foreach ($post->categories as $category)
                        <a href="{{ route('blog.category', $category) }}" class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-medium text-zinc-900 hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-100 dark:hover:bg-zinc-700">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>

                <h1 class="mb-4 text-4xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100 sm:text-5xl">
                    {{ $post->title }}
                </h1>

                @if ($post->excerpt)
                    <p class="mb-6 text-xl text-zinc-600 dark:text-zinc-400">
                        {{ $post->excerpt }}
                    </p>
                @endif

                <div class="flex items-center gap-4 text-sm text-zinc-500 dark:text-zinc-500">
                    <span>By {{ $post->user->name }}</span>
                    <span>•</span>
                    <time datetime="{{ $post->published_at?->toIso8601String() }}">
                        {{ $post->published_at?->format('F d, Y') }}
                    </time>
                </div>
            </header>

            <!-- Post Content -->
            <div class="prose prose-zinc dark:prose-invert max-w-none">
                {!! nl2br(e($post->content)) !!}
            </div>

            <!-- Post Footer -->
            <footer class="mt-12 border-t border-zinc-200 pt-8 dark:border-zinc-800">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Categories</h3>
                        <div class="mt-2 flex flex-wrap gap-2">
                            @foreach ($post->categories as $category)
                                <a href="{{ route('blog.category', $category) }}" class="rounded-full border border-zinc-300 px-3 py-1 text-sm font-medium text-zinc-900 hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-100 dark:hover:bg-zinc-800">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-zinc-900 hover:text-zinc-700 dark:text-zinc-100 dark:hover:text-zinc-300">
                        View all posts
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
            </footer>
        </div>
    </article>
</x-layouts.public>
