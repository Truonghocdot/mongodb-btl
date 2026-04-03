<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Book;
use App\Models\Member;
use App\Models\Loan;
use App\Models\Fine;

class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'total_books' => Book::count(),
            'total_members' => Member::count(),
            'active_loans' => Loan::where('status', 'borrowed')->count(),
            'overdue_loans' => Loan::where('status', 'borrowed')
                ->where('due_date', '<', now()->toDateString())
                ->count(),
            'unpaid_fines' => Fine::where('status', 'unpaid')->count(),
            'unpaid_amount' => Fine::where('status', 'unpaid')->sum('amount'),
        ];

        $recent_activities = Loan::with(['book', 'member'])
            ->latest()
            ->limit(5)
            ->get();

        return view('livewire.dashboard', [
            'stats' => $stats,
            'recent_activities' => $recent_activities,
        ])->layout('components.layouts.app', ['title' => 'Dashboard']);
    }
}
