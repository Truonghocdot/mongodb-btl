<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Book;
use App\Models\Category;
use App\Models\Reservation;
use Livewire\WithPagination;

class Home extends Component
{
    use WithPagination;

    public $search = '';
    public $category_id = '';

    public function reserve($bookId)
    {
        if (!session()->has('member_id')) {
            session()->flash('error', 'Please sign in to the Member Portal to reserve books.');
            return redirect('/portal');
        }

        $book = Book::find($bookId);
        if (!$book || $book->quantity <= 0) {
            session()->flash('error', 'Book is currently unavailable.');
            return;
        }

        $hasPending = Reservation::where('book_id', $bookId)
            ->where('member_id', session('member_id'))
            ->where('status', 'pending')
            ->exists();

        if ($hasPending) {
            session()->flash('error', 'You already have a pending reservation for this book.');
            return;
        }

        Reservation::create([
            'book_id' => $bookId,
            'member_id' => session('member_id'),
            'status' => 'pending',
            'request_date' => now()->toDateString(),
        ]);

        session()->flash('message', 'Reservation request sent successfully!');
    }

    public function updatingSearch() { $this->resetPage(); }
    public function updatingCategoryId() { $this->resetPage(); }

    public function render()
    {
        $books = Book::with('category')
            ->where(function($query) {
                $query->where('title', 'like', '%'.$this->search.'%')
                      ->orWhere('author', 'like', '%'.$this->search.'%')
                      ->orWhere('isbn', 'like', '%'.$this->search.'%');
            })
            ->when($this->category_id, function($query) {
                $query->where('category_id', $this->category_id);
            })
            ->paginate(12);

        return view('livewire.home', [
            'books' => $books,
            'categories' => Category::all(),
        ])->layout('components.layouts.user');
    }
}
