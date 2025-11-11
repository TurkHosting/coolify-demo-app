<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function deletePost(Post $post): void
    {
        $post->delete();

        session()->flash('success', 'Post deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.posts.index', [
            'posts' => Post::query()
                ->with(['user', 'categories'])
                ->when($this->search, fn ($query) => $query->where('title', 'like', "%{$this->search}%"))
                ->latest()
                ->paginate(10),
        ]);
    }
}
