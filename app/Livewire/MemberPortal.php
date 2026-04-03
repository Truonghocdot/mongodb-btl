<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Member;
use App\Models\Loan;
use App\Models\Reservation;
use App\Models\Fine;

class MemberPortal extends Component
{
    public $email, $phone;
    public $isLoggedIn = false;
    public $member;

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        $member = Member::where('email', $this->email)
            ->where('phone', $this->phone)
            ->first();

        if ($member) {
            $this->member = $member;
            $this->isLoggedIn = true;
            session()->put('member_id', $member->id);
        } else {
            session()->flash('error', 'Invalid email or phone number. Are you registered?');
        }
    }

    public function logout()
    {
        $this->isLoggedIn = false;
        $this->member = null;
        session()->forget('member_id');
    }

    public function mount()
    {
        if (session()->has('member_id')) {
            $this->member = Member::find(session('member_id'));
            if ($this->member) {
                $this->isLoggedIn = true;
            }
        }
    }

    public function render()
    {
        $loans = [];
        $reservations = [];
        $fines = [];
        if ($this->isLoggedIn && $this->member) {
            $loans = Loan::with('book')
                ->where('member_id', $this->member->id)
                ->orderBy('borrow_date', 'desc')
                ->get();
            
            $reservations = Reservation::with('book')
                ->where('member_id', $this->member->id)
                ->orderBy('request_date', 'desc')
                ->get();

            $fines = Fine::with('loan.book')
                ->where('member_id', $this->member->id)
                ->orderBy('issued_at', 'desc')
                ->get();
        }

        return view('livewire.member-portal', [
            'loans' => $loans,
            'reservations' => $reservations,
            'fines' => $fines,
        ])->layout('components.layouts.user', ['title' => 'Member Portal']);
    }
}
