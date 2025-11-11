<div class="mx-auto max-w-7xl space-y-6 p-6 lg:px-8">
    <div class="flex items-center justify-between">
        <flux:heading size="xl">Blog Posts</flux:heading>
        <flux:button :href="route('admin.posts.create')" icon="plus" wire:navigate>New Post</flux:button>
    </div>

    @if (session('success'))
        <flux:callout variant="success" icon="check-circle">
            {{ session('success') }}
        </flux:callout>
    @endif

    <div class="space-y-4">
        <flux:input wire:model.live.debounce.300ms="search" placeholder="Search posts..." icon="magnifying-glass" />

        <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700">
            <table class="w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-700 dark:text-zinc-300">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-700 dark:text-zinc-300 whitespace-nowrap">Author</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-700 dark:text-zinc-300 whitespace-nowrap">Categories</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-700 dark:text-zinc-300 whitespace-nowrap">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-700 dark:text-zinc-300 whitespace-nowrap">Published</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-700 dark:text-zinc-300 whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 bg-white dark:divide-zinc-700 dark:bg-zinc-900">
                    @forelse ($posts as $post)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800">
                            <td class="px-6 py-4">
                                <div class="font-medium text-zinc-900 dark:text-zinc-100">{{ $post->title }}</div>
                                <div class="text-sm text-zinc-500 dark:text-zinc-400">{{ Str::limit($post->excerpt, 60) }}</div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-zinc-700 dark:text-zinc-300">{{ $post->user->name }}</td>
                            <td class="px-6 py-4">
                                @if ($post->categories->isNotEmpty())
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($post->categories as $category)
                                            <flux:badge size="sm">{{ $category->name }}</flux:badge>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-sm text-zinc-400 whitespace-nowrap">No categories</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                @if ($post->isPublished())
                                    <flux:badge variant="success">Published</flux:badge>
                                @else
                                    <flux:badge>Draft</flux:badge>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-zinc-700 dark:text-zinc-300">
                                @if ($post->published_at)
                                    {{ $post->published_at->format('M d, Y') }}
                                @else
                                    <span class="text-zinc-400">—</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex gap-2">
                                    <flux:button size="sm" variant="ghost" :href="route('admin.posts.edit', $post)" icon="pencil" wire:navigate>Edit</flux:button>
                                    <flux:button size="sm" variant="danger" wire:click="deletePost({{ $post->id }})" wire:confirm="Are you sure you want to delete this post?" icon="trash">Delete</flux:button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                No posts found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $posts->links() }}
    </div>
</div>
