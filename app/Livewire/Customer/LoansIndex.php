<?php

namespace App\Livewire\Customer;

use App\Models\Loan;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class LoansIndex extends Component
{
    use WithPagination;

    private function resolveMember(): Member
    {
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

        return $member;
    }

    public function render()
    {
        $member = $this->resolveMember();

        $loans = Loan::with('book')
            ->where('member_id', (string) $member->id)
            ->orderBy('borrow_date', 'desc')
            ->paginate(10);

        return view('livewire.customer.loans-index', [
            'loans' => $loans,
        ])->layout('components.layouts.user', ['title' => 'My Loans']);
    }
}
