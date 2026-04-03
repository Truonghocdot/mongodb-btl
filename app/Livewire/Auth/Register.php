<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Register extends Component
{
    public $name = '';
    public $email = '';
    public $phone = '';
    public $address = '';
    public $password = '';
    public $password_confirmation = '';

    public function register()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:mongodb.users,email',
            'phone' => 'required|string|max:30',
            'address' => 'nullable|string|max:500',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'password' => $validated['password'],
            'role' => 'customer',
        ]);

        Auth::login($user);

        return redirect()->to('/customer/orders');
    }

    public function render()
    {
        return view('livewire.auth.register')
            ->layout('components.layouts.user', ['title' => 'Customer Registration']);
    }
}
