<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Str;
use Livewire\Component;

class Edit extends Component
{
    public Post $post;

    public $title = '';

    public $slug = '';

    public $excerpt = '';

    public $content = '';

    public $published_at = '';

    public $selectedCategories = [];

    public function mount(): void
    {
        $this->title = $this->post->title;
        $this->slug = $this->post->slug;
        $this->excerpt = $this->post->excerpt;
        $this->content = $this->post->content;
        $this->published_at = $this->post->published_at?->format('Y-m-d\TH:i');
        $this->selectedCategories = $this->post->categories->pluck('id')->toArray();
    }

    public function updatedTitle(): void
    {
        $this->slug = Str::slug($this->title);
    }

    public function save(): void
    {
        $validated = $this->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug,'.$this->post->id,
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'selectedCategories' => 'array',
        ]);

        $this->post->update([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'excerpt' => $validated['excerpt'],
            'content' => $validated['content'],
            'published_at' => $validated['published_at'] ? now()->parse($validated['published_at']) : null,
        ]);

        $this->post->categories()->sync($this->selectedCategories);

        session()->flash('success', 'Post updated successfully.');

        $this->redirect(route('admin.posts.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.posts.edit', [
            'categories' => Category::all(),
        ]);
    }
}
