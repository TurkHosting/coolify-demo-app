<x-layouts.public>
    <div class="bg-white py-12 dark:bg-zinc-900">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Back Link -->
            <div class="mb-8">
                <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to all posts
                </a>
            </div>

            <div class="mb-12">
                <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">{{ $category->name }}</h1>
                <p class="mt-4 text-zinc-600 dark:text-zinc-400">Browse all posts in this category</p>
            </div>

            <!-- Blog Posts Grid -->
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @php
                    $posts = $category->posts()
                        ->with(['categories', 'user'])
                        ->whereNotNull('published_at')
                        ->where('published_at', '<=', now())
                        ->latest('published_at')
                        ->paginate(12);
                @endphp

                @forelse ($posts as $post)
                    <article class="flex flex-col overflow-hidden rounded-lg border border-zinc-200 bg-white shadow-sm transition hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900">
                        <div class="flex flex-1 flex-col p-6">
                            <div class="mb-3 flex flex-wrap gap-2">
                                @foreach ($post->categories as $cat)
                                    <a href="{{ route('blog.category', $cat) }}" class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-medium text-zinc-900 hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-100 dark:hover:bg-zinc-700">
                                        {{ $cat->name }}
                                    </a>
                                @endforeach
                            </div>
                            <h2 class="mb-2 text-xl font-semibold text-zinc-900 dark:text-zinc-100">
                                <a href="{{ route('blog.show', $post) }}" class="hover:text-zinc-700 dark:hover:text-zinc-300">
                                    {{ $post->title }}
                                </a>
                            </h2>
                            <p class="mb-4 flex-1 text-sm text-zinc-600 dark:text-zinc-400">
                                {{ Str::limit($post->excerpt, 120) }}
                            </p>
                            <div class="flex items-center justify-between text-xs text-zinc-500 dark:text-zinc-500">
                                <span>{{ $post->published_at->format('M d, Y') }}</span>
                                <a href="{{ route('blog.show', $post) }}" class="font-medium text-zinc-900 hover:text-zinc-700 dark:text-zinc-100 dark:hover:text-zinc-300">
                                    Read more →
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-12 text-center">
                        <p class="text-zinc-600 dark:text-zinc-400">No blog posts in this category yet.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($posts->hasPages())
                <div class="mt-12">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.public>
