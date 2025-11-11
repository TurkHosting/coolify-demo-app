<div class="mx-auto max-w-7xl space-y-6 p-6 lg:px-8">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Categories</flux:heading>
            <flux:button :href="route('admin.categories.create')" icon="plus" wire:navigate>New Category</flux:button>
        </div>

        @if (session('success'))
            <flux:callout variant="success" icon="check-circle">
                {{ session('success') }}
            </flux:callout>
        @endif

        <div class="space-y-4">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Search categories..." icon="magnifying-glass" />

            <div class="overflow-hidden rounded-lg border border-zinc-200 dark:border-zinc-700">
                <table class="w-full table-auto divide-y divide-zinc-200 dark:divide-zinc-700">
                    <thead class="bg-zinc-50 dark:bg-zinc-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-700 dark:text-zinc-300">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-700 dark:text-zinc-300">Slug</th>
                            <th class="w-20 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-700 dark:text-zinc-300">Posts</th>
                            <th class="w-32 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-700 dark:text-zinc-300">Created</th>
                            <th class="w-48 px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-700 dark:text-zinc-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 bg-white dark:divide-zinc-700 dark:bg-zinc-900">
                        @forelse ($categories as $category)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800">
                                <td class="whitespace-nowrap px-6 py-4 font-medium text-zinc-900 dark:text-zinc-100">{{ $category->name }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-zinc-700 dark:text-zinc-300">{{ $category->slug }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-zinc-700 dark:text-zinc-300">{{ $category->posts_count }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-zinc-700 dark:text-zinc-300">{{ $category->created_at->format('M d, Y') }}</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex gap-2">
                                        <flux:button size="sm" variant="ghost" :href="route('admin.categories.edit', $category)" icon="pencil" wire:navigate>Edit</flux:button>
                                        <flux:button size="sm" variant="danger" wire:click="deleteCategory({{ $category->id }})" wire:confirm="Are you sure you want to delete this category?" icon="trash">Delete</flux:button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                    No categories found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $categories->links() }}
        </div>
</div>
