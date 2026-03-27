<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Reservation;
use App\Models\Loan;
use App\Models\Book;
use Livewire\WithPagination;

class Reservations extends Component
{
    use WithPagination;

    public function approve($id)
    {
        $reservation = Reservation::findOrFail($id);
        
        $book = Book::find($reservation->book_id);
        if ($book->quantity <= 0) {
            session()->flash('error', 'Book is out of stock. Cannot approve.');
            return;
        }

        // Create Loan
        Loan::create([
            'book_id' => $reservation->book_id,
            'member_id' => $reservation->member_id,
            'borrow_date' => now()->toDateString(),
            'due_date' => now()->addDays(14)->toDateString(),
            'status' => 'borrowed',
        ]);

        // Decrement quantity
        $book->decrement('quantity');

        // Update Reservation
        $reservation->update(['status' => 'approved']);

        session()->flash('message', 'Reservation Approved and Loan Created.');
    }

    public function cancel($id)
    {
        Reservation::findOrFail($id)->update(['status' => 'cancelled']);
        session()->flash('message', 'Reservation Cancelled.');
    }

    public function render()
    {
        return view('livewire.admin.reservations', [
            'reservations' => Reservation::with(['book', 'member'])->latest()->paginate(10)
        ])->layout('components.layouts.app', ['title' => 'Manage Reservations']);
    }
}
