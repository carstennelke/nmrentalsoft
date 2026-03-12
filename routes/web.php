<?php

use App\Livewire\Customers;
use App\Livewire\ItemSets;
use App\Livewire\Items;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::get('items', Items\Index::class)->name('items.index');
    Route::get('items/create', Items\Create::class)->name('items.create');
    Route::get('items/{item}/edit', Items\Edit::class)->name('items.edit');

    Route::get('item-sets', ItemSets\Index::class)->name('item-sets.index');
    Route::get('item-sets/create', ItemSets\Create::class)->name('item-sets.create');
    Route::get('item-sets/{itemSet}/edit', ItemSets\Edit::class)->name('item-sets.edit');

    Route::get('customers', Customers\Index::class)->name('customers.index');
    Route::get('customers/create', Customers\Create::class)->name('customers.create');
    Route::get('customers/{customer}/edit', Customers\Edit::class)->name('customers.edit');
});

require __DIR__.'/settings.php';
