<?php

namespace App\Livewire\Categories;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $name, $description;
    public $selected_id;
    public $isEditMode = false;

    public function updated(string $property): void
    {
        $this->resetValidation($property);
    }

    public function render()
    {
        $categories = Category::where('name', 'like', '%'.$this->search.'%')
            ->paginate(10);

        return view('livewire.categories.index', [
            'categories' => $categories,
        ])->layout('components.layouts.app', ['title' => 'Manage Categories']);
    }

    public function resetFields()
    {
        $this->name = '';
        $this->description = '';
        $this->selected_id = null;
        $this->isEditMode = false;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|unique:mongodb.categories,name',
        ]);

        Category::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->resetFields();
        session()->flash('message', 'Category Created Successfully.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->selected_id = $id;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->isEditMode = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
        ]);

        if ($this->selected_id) {
            $category = Category::find($this->selected_id);
            $category->update([
                'name' => $this->name,
                'description' => $this->description,
            ]);
            $this->resetFields();
            session()->flash('message', 'Category Updated Successfully.');
        }
    }

    public function delete($id)
    {
        Category::find($id)->delete();
        session()->flash('message', 'Category Deleted Successfully.');
    }
}
