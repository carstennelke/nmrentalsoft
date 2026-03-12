<?php

use App\Livewire\Items\Edit;
use App\Models\Item;
use App\Models\User;
use Livewire\Livewire;

test('guests are redirected to login', function () {
    $item = Item::factory()->create();

    $this->get(route('items.edit', $item))->assertRedirect(route('login'));
});

test('authenticated users can visit the edit page', function () {
    $this->actingAs(User::factory()->create());
    $item = Item::factory()->create();

    $this->get(route('items.edit', $item))->assertOk();
});

test('edit page is pre-filled with current item data', function () {
    $this->actingAs(User::factory()->create());

    $item = Item::factory()->create([
        'short_name' => 'MIC-001',
        'long_name' => 'Shure SM58',
        'description' => 'Dynamisches Mikrofon.',
        'has_dry_hire_option' => true,
        'unit' => 'Stk',
    ]);

    Livewire::test(Edit::class, ['item' => $item])
        ->assertSet('short_name', 'MIC-001')
        ->assertSet('long_name', 'Shure SM58')
        ->assertSet('description', 'Dynamisches Mikrofon.')
        ->assertSet('has_dry_hire_option', true)
        ->assertSet('unit', 'Stk');
});

test('item can be updated with valid data', function () {
    $this->actingAs(User::factory()->create());

    $item = Item::factory()->create();

    Livewire::test(Edit::class, ['item' => $item])
        ->set('short_name', 'UPD-001')
        ->set('long_name', 'Aktualisierter Langname')
        ->set('description', 'Neue Beschreibung nach Update.')
        ->set('has_dry_hire_option', false)
        ->set('unit', 'Set')
        ->call('update')
        ->assertHasNoErrors()
        ->assertRedirect(route('items.index'));

    $item->refresh();
    expect($item->short_name)->toBe('UPD-001');
    expect($item->long_name)->toBe('Aktualisierter Langname');
    expect($item->description)->toBe('Neue Beschreibung nach Update.');
    expect($item->has_dry_hire_option)->toBeFalse();
    expect($item->unit)->toBe('Set');
});

test('short_name is required on update', function () {
    $this->actingAs(User::factory()->create());
    $item = Item::factory()->create();

    Livewire::test(Edit::class, ['item' => $item])
        ->set('short_name', '')
        ->call('update')
        ->assertHasErrors(['short_name' => 'required']);
});

test('short_name must not exceed 12 characters on update', function () {
    $this->actingAs(User::factory()->create());
    $item = Item::factory()->create();

    Livewire::test(Edit::class, ['item' => $item])
        ->set('short_name', 'ABCDEFGHIJKLM') // 13 Zeichen
        ->call('update')
        ->assertHasErrors(['short_name' => 'max']);
});

test('long_name is required on update', function () {
    $this->actingAs(User::factory()->create());
    $item = Item::factory()->create();

    Livewire::test(Edit::class, ['item' => $item])
        ->set('long_name', '')
        ->call('update')
        ->assertHasErrors(['long_name' => 'required']);
});

test('long_name must not exceed 100 characters on update', function () {
    $this->actingAs(User::factory()->create());
    $item = Item::factory()->create();

    Livewire::test(Edit::class, ['item' => $item])
        ->set('long_name', str_repeat('A', 101))
        ->call('update')
        ->assertHasErrors(['long_name' => 'max']);
});

test('description is required on update', function () {
    $this->actingAs(User::factory()->create());
    $item = Item::factory()->create();

    Livewire::test(Edit::class, ['item' => $item])
        ->set('description', '')
        ->call('update')
        ->assertHasErrors(['description' => 'required']);
});

test('unit is required on update', function () {
    $this->actingAs(User::factory()->create());
    $item = Item::factory()->create();

    Livewire::test(Edit::class, ['item' => $item])
        ->set('unit', '')
        ->call('update')
        ->assertHasErrors(['unit' => 'required']);
});

test('unit must not exceed 10 characters on update', function () {
    $this->actingAs(User::factory()->create());
    $item = Item::factory()->create();

    Livewire::test(Edit::class, ['item' => $item])
        ->set('unit', 'ABCDEFGHIJK') // 11 Zeichen
        ->call('update')
        ->assertHasErrors(['unit' => 'max']);
});

test('other items are not affected by update', function () {
    $this->actingAs(User::factory()->create());

    $item = Item::factory()->create(['short_name' => 'TARGET']);
    $other = Item::factory()->create(['short_name' => 'OTHER']);

    Livewire::test(Edit::class, ['item' => $item])
        ->set('short_name', 'CHANGED')
        ->set('long_name', 'Geänderter Name')
        ->set('description', 'Neue Beschreibung.')
        ->set('unit', 'Stk')
        ->call('update')
        ->assertHasNoErrors();

    expect($other->fresh()->short_name)->toBe('OTHER');
});
