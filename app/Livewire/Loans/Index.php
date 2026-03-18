<?php

namespace App\Livewire\Loans;

use Livewire\Component;
use App\Models\Loan;
use App\Models\Book;
use App\Models\Member;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $book_id, $member_id, $due_date;
    public $selected_id;
    public $isEditMode = false;

    public function render()
    {
        $loans = Loan::with(['book', 'member'])
            ->paginate(10);

        return view('livewire.loans.index', [
            'loans' => $loans,
            'books' => Book::all(),
            'members' => Member::all(),
        ])->layout('components.layouts.app', ['title' => 'Manage Loans']);
    }

    public function resetFields()
    {
        $this->book_id = '';
        $this->member_id = '';
        $this->due_date = '';
        $this->selected_id = null;
        $this->isEditMode = false;
    }

    public function store()
    {
        $this->validate([
            'book_id' => 'required',
            'member_id' => 'required',
            'due_date' => 'required|date',
        ]);

        $book = Book::find($this->book_id);
        
        if ($book->quantity <= 0) {
            session()->flash('error', 'This book is currently out of stock.');
            return;
        }

        Loan::create([
            'book_id' => $this->book_id,
            'member_id' => $this->member_id,
            'borrow_date' => now()->toDateString(),
            'due_date' => $this->due_date,
            'status' => 'borrowed',
        ]);

        // Decrement quantity
        $book->decrement('quantity');

        $this->resetFields();
        session()->flash('message', 'Loan Created Successfully.');
    }

    public function markAsReturned($id)
    {
        $loan = Loan::find($id);
        
        if ($loan->status === 'returned') {
            return;
        }

        $loan->update([
            'return_date' => now()->toDateString(),
            'status' => 'returned',
        ]);

        // Increment quantity
        $book = Book::find($loan->book_id);
        if ($book) {
            $book->increment('quantity');
        }

        session()->flash('message', 'Book Returned Successfully.');
    }

    public function delete($id)
    {
        Loan::find($id)->delete();
        session()->flash('message', 'Loan Deleted Successfully.');
    }
}
