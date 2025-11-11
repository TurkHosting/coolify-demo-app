<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class Create extends Component
{
    public $title = '';

    public $slug = '';

    public $excerpt = '';

    public $content = '';

    public $published_at = '';

    public $selectedCategories = [];

    public function updatedTitle(): void
    {
        $this->slug = Str::slug($this->title);
    }

    public function save(): void
    {
        $validated = $this->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'selectedCategories' => 'array',
        ]);

        $post = auth()->user()->posts()->create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'excerpt' => $validated['excerpt'],
            'content' => $validated['content'],
            'published_at' => $validated['published_at'] ? now()->parse($validated['published_at']) : null,
        ]);

        if (! empty($this->selectedCategories)) {
            $post->categories()->attach($this->selectedCategories);
        }

        session()->flash('success', 'Post created successfully.');

        $this->redirect(route('admin.posts.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.posts.create', [
            'categories' => Category::all(),
        ]);
    }
}
