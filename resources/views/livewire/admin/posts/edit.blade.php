<div class="mx-auto max-w-4xl space-y-6 p-6 lg:px-8">
        <div>
            <flux:heading size="xl">Edit Blog Post</flux:heading>
            <flux:text>Update the blog post details.</flux:text>
        </div>

        <form wire:submit="save" class="space-y-6">
            <flux:field>
                <flux:label>Title</flux:label>
                <flux:input wire:model.live="title" placeholder="Enter post title" />
                <flux:error name="title" />
            </flux:field>

            <flux:field>
                <flux:label>Slug</flux:label>
                <flux:input wire:model="slug" placeholder="auto-generated-slug" />
                <flux:error name="slug" />
                <flux:text>The URL-friendly version of the title. Auto-generated from the title.</flux:text>
            </flux:field>

            <flux:field>
                <flux:label>Excerpt</flux:label>
                <flux:textarea wire:model="excerpt" placeholder="Brief summary of the post..." rows="3" />
                <flux:error name="excerpt" />
                <flux:text>A short description that appears in post listings.</flux:text>
            </flux:field>

            <flux:field>
                <flux:label>Content</flux:label>
                <flux:textarea wire:model="content" placeholder="Write your blog post content here... Supports HTML formatting." rows="15" />
                <flux:error name="content" />
                <flux:text>The main content of your blog post. Supports HTML formatting.</flux:text>
            </flux:field>

            <flux:field>
                <flux:label>Categories</flux:label>
                <div class="space-y-2">
                    @foreach ($categories as $category)
                        <flux:checkbox wire:model="selectedCategories" :value="$category->id" :label="$category->name" />
                    @endforeach
                </div>
                <flux:error name="selectedCategories" />
            </flux:field>

            <flux:field>
                <flux:label>Publish Date</flux:label>
                <flux:input type="datetime-local" wire:model="published_at" />
                <flux:error name="published_at" />
                <flux:text>Leave empty to save as draft. Set a date to publish immediately or schedule for later.</flux:text>
            </flux:field>

            <div class="flex gap-2">
                <flux:button type="submit" variant="primary">Update Post</flux:button>
                <flux:button :href="route('admin.posts.index')" variant="ghost" wire:navigate>Cancel</flux:button>
            </div>
        </form>
</div>
