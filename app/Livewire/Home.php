<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Book;
use App\Models\Category;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class Home extends Component
{
    use WithPagination;

    public $search = '';
    public $category_id = '';

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

    public function reserve($bookId)
    {
        $memberId = $this->resolveMemberId();
        if (!$memberId) {
            session()->flash('error', 'Please login as customer to reserve books.');
            $this->redirect('/login', navigate: true);
            return;
        }

        $book = Book::find($bookId);
        if (!$book || $book->quantity <= 0) {
            session()->flash('error', 'Book is currently unavailable.');
            return;
        }

        $hasPending = Reservation::where('book_id', $bookId)
            ->where('member_id', $memberId)
            ->where('status', 'pending')
            ->exists();

        if ($hasPending) {
            session()->flash('error', 'You already have a pending reservation for this book.');
            return;
        }

        Reservation::create([
            'book_id' => $bookId,
            'member_id' => $memberId,
            'status' => 'pending',
            'request_date' => now()->toDateString(),
        ]);

        session()->flash('message', 'Reservation request sent successfully!');
    }

    public function borrow($bookId)
    {
        $memberId = $this->resolveMemberId();
        if (!$memberId) {
            session()->flash('error', 'Please login as customer to borrow books.');
            $this->redirect('/login', navigate: true);
            return;
        }

        $book = Book::find($bookId);
        if (!$book || $book->quantity <= 0) {
            session()->flash('error', 'Book is currently unavailable.');
            return;
        }

        $hasActiveLoan = Loan::where('book_id', $bookId)
            ->where('member_id', $memberId)
            ->where('status', 'borrowed')
            ->exists();

        if ($hasActiveLoan) {
            session()->flash('error', 'You already have an active loan for this book.');
            return;
        }

        Loan::create([
            'book_id' => $bookId,
            'member_id' => $memberId,
            'borrow_date' => now()->toDateString(),
            'due_date' => now()->addDays(14)->toDateString(),
            'status' => 'borrowed',
        ]);

        $book->decrement('quantity');
        session()->flash('message', 'Borrowed successfully. Please return before due date.');
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
