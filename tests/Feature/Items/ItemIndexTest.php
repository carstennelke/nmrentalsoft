<?php

use App\Livewire\Items\Index;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Livewire;

test('guests are redirected to login', function () {
    $this->get(route('items.index'))->assertRedirect(route('login'));
});

test('authenticated users can visit the items index', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('items.index'))->assertOk();
});

test('items are listed in the table', function () {
    $this->actingAs(User::factory()->create());

    $items = Item::factory()->count(3)->create();

    Livewire::test(Index::class)
        ->assertSee($items[0]->short_name)
        ->assertSee($items[1]->short_name)
        ->assertSee($items[2]->short_name);
});

test('search filters items by short_name', function () {
    $this->actingAs(User::factory()->create());

    $match = Item::factory()->create(['short_name' => 'FINDME', 'long_name' => 'Ignored']);
    $other = Item::factory()->create(['short_name' => 'OTHER', 'long_name' => 'Ignored']);

    Livewire::test(Index::class)
        ->set('search', 'FINDME')
        ->assertSee($match->short_name)
        ->assertDontSee($other->short_name);
});

test('search filters items by long_name', function () {
    $this->actingAs(User::factory()->create());

    $match = Item::factory()->create(['short_name' => 'X', 'long_name' => 'Suchbarer Langname']);
    $other = Item::factory()->create(['short_name' => 'Y', 'long_name' => 'Anderer Name']);

    Livewire::test(Index::class)
        ->set('search', 'Suchbarer')
        ->assertSee($match->long_name)
        ->assertDontSee($other->long_name);
});

test('item can be deleted', function () {
    $this->actingAs(User::factory()->create());

    $item = Item::factory()->create();

    Livewire::test(Index::class)
        ->call('delete', $item->id)
        ->assertHasNoErrors();

    expect(Item::find($item->id))->toBeNull();
});

test('deleting a non-existent item throws 404', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(Index::class)
        ->call('delete', 99999);
})->throws(ModelNotFoundException::class);
