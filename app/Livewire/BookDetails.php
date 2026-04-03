<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Reservation;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class BookDetails extends Component
{
    public $book;
    public $rating = 5;
    public $comment = '';

    public function updated(string $property): void
    {
        $this->resetValidation($property);
    }

    public function mount($id)
    {
        $this->book = Book::with('category')->findOrFail($id);
    }

    private function resolveMemberId(): ?string
    {
        if (Auth::check() && Auth::user()->isCustomer()) {
            $user = Auth::user();
            $member = Member::firstOrCreate(
                ['email' => $user->email],
                [
                    'name' => $user->name,
                    'phone' => $user->phone ?? '',
                    'address' => $user->address ?? '',
                    'join_date' => now()->toDateString(),
                ]
            );

            $member->update([
                'name' => $user->name,
                'phone' => $user->phone ?? $member->phone,
                'address' => $user->address ?? $member->address,
            ]);

            return (string) $member->id;
        }

        return session('member_id');
    }

    public function reserveBook(): void
    {
        $memberId = $this->resolveMemberId();
        if (!$memberId) {
            session()->flash('error', 'Please login as customer to reserve books.');
            $this->redirect('/login', navigate: true);
            return;
        }

        if ($this->book->quantity <= 0) {
            session()->flash('error', 'Book is currently unavailable.');
            return;
        }

        $hasPending = Reservation::where('book_id', $this->book->id)
            ->where('member_id', $memberId)
            ->where('status', 'pending')
            ->exists();

        if ($hasPending) {
            session()->flash('error', 'You already have a pending reservation for this book.');
            return;
        }

        Reservation::create([
            'book_id' => $this->book->id,
            'member_id' => $memberId,
            'status' => 'pending',
            'request_date' => now()->toDateString(),
        ]);

        session()->flash('message', 'Reservation request sent successfully!');
    }

    public function borrowBook(): void
    {
        $memberId = $this->resolveMemberId();
        if (!$memberId) {
            session()->flash('error', 'Please login as customer to borrow books.');
            $this->redirect('/login', navigate: true);
            return;
        }

        $book = Book::find($this->book->id);
        if (!$book || $book->quantity <= 0) {
            session()->flash('error', 'Book is currently unavailable.');
            return;
        }

        $hasActiveLoan = Loan::where('book_id', $book->id)
            ->where('member_id', $memberId)
            ->where('status', 'borrowed')
            ->exists();

        if ($hasActiveLoan) {
            session()->flash('error', 'You already have an active loan for this book.');
            return;
        }

        Loan::create([
            'book_id' => $book->id,
            'member_id' => $memberId,
            'borrow_date' => now()->toDateString(),
            'due_date' => now()->addDays(14)->toDateString(),
            'status' => 'borrowed',
        ]);

        $book->decrement('quantity');
        $this->book = $book->fresh('category');

        session()->flash('message', 'Borrowed successfully. Please return before due date.');
    }

    public function submitReview()
    {
        $memberId = $this->resolveMemberId();
        if (!$memberId) {
            session()->flash('error', 'Please login as customer to leave a review.');
            return redirect('/login');
        }

        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|min:5',
        ]);

        Review::create([
            'book_id' => $this->book->id,
            'member_id' => $memberId,
            'rating' => (int)$this->rating,
            'comment' => $this->comment,
        ]);

        $this->reset('comment');
        $this->rating = 5;
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
