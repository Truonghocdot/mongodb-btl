<?php

namespace App\Livewire\Books;

use Livewire\Component;
use App\Models\Book;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $title, $author, $isbn, $category_id, $quantity;
    public $selected_id;
    public $isEditMode = false;

    public function updated(string $property): void
    {
        $this->resetValidation($property);
    }

    public function render()
    {
        $books = Book::with('category')
            ->where(function($query) {
                $query->where('title', 'like', '%'.$this->search.'%')
                      ->orWhere('author', 'like', '%'.$this->search.'%')
                      ->orWhere('isbn', 'like', '%'.$this->search.'%');
            })
            ->paginate(10);

        return view('livewire.books.index', [
            'books' => $books,
            'categories' => \App\Models\Category::all(),
        ])->layout('components.layouts.app', ['title' => 'Manage Books']);
    }

    public function resetFields()
    {
        $this->title = '';
        $this->author = '';
        $this->isbn = '';
        $this->category_id = '';
        $this->quantity = '';
        $this->selected_id = null;
        $this->isEditMode = false;
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'author' => 'required',
            'isbn' => 'required|unique:mongodb.books,isbn',
            'quantity' => 'required|numeric',
        ]);

        Book::create([
            'title' => $this->title,
            'author' => $this->author,
            'isbn' => $this->isbn,
            'category_id' => $this->category_id,
            'quantity' => $this->quantity,
            'status' => 'available',
        ]);

        $this->resetFields();
        session()->flash('message', 'Book Created Successfully.');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $this->selected_id = $id;
        $this->title = $book->title;
        $this->author = $book->author;
        $this->isbn = $book->isbn;
        $this->category_id = $book->category_id;
        $this->quantity = $book->quantity;
        $this->isEditMode = true;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required',
            'author' => 'required',
            'isbn' => [
                'required',
                Rule::unique('mongodb.books', 'isbn')->ignore($this->selected_id, '_id'),
            ],
            'quantity' => 'required|numeric',
        ]);

        if ($this->selected_id) {
            $book = Book::find($this->selected_id);
            $book->update([
                'title' => $this->title,
                'author' => $this->author,
                'isbn' => $this->isbn,
                'category_id' => $this->category_id,
                'quantity' => $this->quantity,
            ]);
            $this->resetFields();
            session()->flash('message', 'Book Updated Successfully.');
        }
    }

    public function delete($id)
    {
        Book::find($id)->delete();
        session()->flash('message', 'Book Deleted Successfully.');
    }
}
