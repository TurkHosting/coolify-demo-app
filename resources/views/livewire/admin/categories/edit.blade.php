<div class="mx-auto max-w-3xl space-y-6 p-6 lg:px-8">
        <div>
            <flux:heading size="xl">Edit Category</flux:heading>
            <flux:text>Update the category details.</flux:text>
        </div>

        <form wire:submit="save" class="space-y-6">
            <flux:field>
                <flux:label>Name</flux:label>
                <flux:input wire:model.live="name" placeholder="Enter category name" />
                <flux:error name="name" />
            </flux:field>

            <flux:field>
                <flux:label>Slug</flux:label>
                <flux:input wire:model="slug" placeholder="auto-generated-slug" />
                <flux:error name="slug" />
                <flux:text>The URL-friendly version of the name. Auto-generated from the name.</flux:text>
            </flux:field>

            <div class="flex gap-2">
                <flux:button type="submit" variant="primary">Update Category</flux:button>
                <flux:button :href="route('admin.categories.index')" variant="ghost" wire:navigate>Cancel</flux:button>
            </div>
        </form>
</div>
