<x-layouts.public>
    <!-- Hero Section -->
    <section class="bg-gradient-to-b from-zinc-50 to-white py-20 dark:from-zinc-900 dark:to-zinc-900">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100 sm:text-6xl">
                    Welcome to {{ config('app.name') }}
                </h1>
                <p class="mx-auto mt-6 max-w-2xl text-lg text-zinc-600 dark:text-zinc-400">
                    A simple demo application showcasing Laravel, Livewire, and modern web development practices.
                </p>
                <div class="mt-10 flex items-center justify-center gap-4">
                    <a href="{{ route('blog.index') }}" class="rounded-lg bg-zinc-900 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-zinc-800 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-200">
                        Read Our Blog
                    </a>
                    @guest
                        <a href="{{ route('login') }}" class="rounded-lg border border-zinc-300 px-6 py-3 text-sm font-semibold text-zinc-900 hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-100 dark:hover:bg-zinc-800">
                            Admin Login
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Blog Posts -->
    <section class="bg-white py-16 dark:bg-zinc-900">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-12 text-center">
                <h2 class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">Latest Blog Posts</h2>
                <p class="mt-4 text-zinc-600 dark:text-zinc-400">Discover our most recent articles</p>
            </div>

            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @php
                    $recentPosts = \App\Models\Post::with('categories')
                        ->whereNotNull('published_at')
                        ->where('published_at', '<=', now())
                        ->latest('published_at')
                        ->take(6)
                        ->get();
                @endphp

                @forelse ($recentPosts as $post)
                    <article class="flex flex-col overflow-hidden rounded-lg border border-zinc-200 bg-white shadow-sm transition hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900">
                        <div class="flex flex-1 flex-col p-6">
                            <div class="mb-3 flex flex-wrap gap-2">
                                @foreach ($post->categories as $category)
                                    <a href="{{ route('blog.category', $category) }}" class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-medium text-zinc-900 hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-100 dark:hover:bg-zinc-700">
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            </div>
                            <h3 class="mb-2 text-xl font-semibold text-zinc-900 dark:text-zinc-100">
                                <a href="{{ route('blog.show', $post) }}" class="hover:text-zinc-700 dark:hover:text-zinc-300">
                                    {{ $post->title }}
                                </a>
                            </h3>
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
                        <p class="text-zinc-600 dark:text-zinc-400">No blog posts available yet.</p>
                    </div>
                @endforelse
            </div>

            @if ($recentPosts->isNotEmpty())
                <div class="mt-12 text-center">
                    <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-zinc-900 hover:text-zinc-700 dark:text-zinc-100 dark:hover:text-zinc-300">
                        View all posts
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </section>
</x-layouts.public>
