<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\Books\Index as BooksIndex;
use App\Livewire\Categories\Index as CategoriesIndex;
use App\Livewire\Members\Index as MembersIndex;
use App\Livewire\Loans\Index as LoansIndex;

Route::get('/', \App\Livewire\Home::class);
Route::get('/books/{id}', \App\Livewire\BookDetails::class);
Route::get('/portal', \App\Livewire\MemberPortal::class);

Route::get('/dashboard', Dashboard::class);
Route::get('/books', BooksIndex::class);
Route::get('/categories', CategoriesIndex::class);
Route::get('/members', MembersIndex::class);
Route::get('/members/{id}', \App\Livewire\Members\Show::class);
Route::get('/loans', LoansIndex::class);
Route::get('/reservations', \App\Livewire\Admin\Reservations::class);
Route::get('/fines', \App\Livewire\Admin\Fines::class);
