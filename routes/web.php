<?php

use App\Livewire\Items;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::get('items', Items\Index::class)->name('items.index');
    Route::get('items/create', Items\Create::class)->name('items.create');
    Route::get('items/{item}/edit', Items\Edit::class)->name('items.edit');
});

require __DIR__.'/settings.php';
