<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\Books\Index as BooksIndex;
use App\Livewire\Categories\Index as CategoriesIndex;
use App\Livewire\Members\Index as MembersIndex;
use App\Livewire\Loans\Index as LoansIndex;

Route::get('/', \App\Livewire\Home::class);
Route::get('/books/{id}', \App\Livewire\BookDetails::class);
Route::get('/portal', \App\Livewire\MemberPortal::class);
Route::get('/login', \App\Livewire\Auth\Login::class)->middleware('guest')->name('login');
Route::get('/register', \App\Livewire\Auth\Register::class)->middleware('guest');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
})->middleware('auth');

Route::middleware(['auth', 'customer'])->group(function () {
    Route::get('/customer/orders', \App\Livewire\Customer\OrdersIndex::class);
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', Dashboard::class);
        Route::get('/books', BooksIndex::class);
        Route::get('/categories', CategoriesIndex::class);
        Route::get('/members', MembersIndex::class);
        Route::get('/members/{id}', \App\Livewire\Members\Show::class);
        Route::get('/loans', LoansIndex::class);
        Route::get('/reservations', \App\Livewire\Admin\Reservations::class);
        Route::get('/fines', \App\Livewire\Admin\Fines::class);
        Route::get('/customers', \App\Livewire\Admin\Customers::class);
        Route::get('/orders', \App\Livewire\Admin\Orders::class);
    });
});
