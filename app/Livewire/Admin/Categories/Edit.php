<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class Edit extends Component
{
    public Category $category;

    public $name = '';

    public $slug = '';

    public function mount(): void
    {
        $this->name = $this->category->name;
        $this->slug = $this->category->slug;
    }

    public function updatedName(): void
    {
        $this->slug = Str::slug($this->name);
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,'.$this->category->id,
        ]);

        $this->category->update($validated);

        session()->flash('success', 'Category updated successfully.');

        $this->redirect(route('admin.categories.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.categories.edit');
    }
}
