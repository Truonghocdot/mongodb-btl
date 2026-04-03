<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email = '';
    public $password = '';

    public function login()
    {
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (! Auth::attempt($credentials)) {
            $this->addError('email', 'Invalid email or password.');
            return;
        }

        session()->regenerate();

        if (Auth::user()->isAdmin()) {
            return redirect()->to('/admin/dashboard');
        }

        return redirect()->to('/customer/orders');
    }

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('components.layouts.user', ['title' => 'Login']);
    }
}
