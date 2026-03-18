<?php

namespace App\Livewire\Members;

use Livewire\Component;
use App\Models\Member;
use App\Models\Loan;

class Show extends Component
{
    public $member;

    public function mount($id)
    {
        $this->member = Member::findOrFail($id);
    }

    public function render()
    {
        $loans = Loan::with('book')
            ->where('member_id', $this->member->id)
            ->orderBy('borrow_date', 'desc')
            ->get();

        return view('livewire.members.show', [
            'loans' => $loans,
        ])->layout('components.layouts.app', ['title' => 'Member Details']);
    }
}
