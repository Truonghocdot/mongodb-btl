<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Book;
use App\Models\Review;

class BookDetails extends Component
{
    public $book;
    public $rating = 5;
    public $comment = '';

    public function mount($id)
    {
        $this->book = Book::with('category')->findOrFail($id);
    }

    public function submitReview()
    {
        if (!session()->has('member_id')) {
            session()->flash('error', 'Please sign in to leave a review.');
            return redirect('/portal');
        }

        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|min:5',
        ]);

        Review::create([
            'book_id' => $this->book->id,
            'member_id' => session('member_id'),
            'rating' => (int)$this->rating,
            'comment' => $this->comment,
        ]);

        $this->reset(['rating', 'comment']);
        session()->flash('message', 'Thank you for your review!');
    }

    public function render()
    {
        $reviews = Review::with('member')
            ->where('book_id', $this->book->id)
            ->latest()
            ->get();

        return view('livewire.book-details', [
            'reviews' => $reviews,
        ])->layout('components.layouts.user', ['title' => $this->book->title]);
    }
}
