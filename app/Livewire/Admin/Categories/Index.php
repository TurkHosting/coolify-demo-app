<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function deleteCategory(Category $category): void
    {
        $category->delete();

        session()->flash('success', 'Category deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.categories.index', [
            'categories' => Category::query()
                ->when($this->search, fn ($query) => $query->where('name', 'like', "%{$this->search}%"))
                ->withCount('posts')
                ->latest()
                ->paginate(10),
        ]);
    }
}
