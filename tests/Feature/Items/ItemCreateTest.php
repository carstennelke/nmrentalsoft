<?php

use App\Livewire\Items\Create;
use App\Models\Item;
use App\Models\User;
use Livewire\Livewire;

test('guests are redirected to login', function () {
    $this->get(route('items.create'))->assertRedirect(route('login'));
});

test('authenticated users can visit the create page', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('items.create'))->assertOk();
});

test('item can be created with valid data', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(Create::class)
        ->set('short_name', 'MIC-001')
        ->set('long_name', 'Shure SM58 Mikrofon')
        ->set('description', 'Klassisches dynamisches Gesangsmikrofon.')
        ->set('has_dry_hire_option', true)
        ->set('unit', 'Stk')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('items.index'));

    expect(Item::where('short_name', 'MIC-001')->exists())->toBeTrue();
});

test('item is created with dry hire option false by default', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(Create::class)
        ->set('short_name', 'CAB-001')
        ->set('long_name', 'XLR Kabel 10m')
        ->set('description', 'Symmetrisches Audiokabel.')
        ->set('unit', 'Stk')
        ->call('save')
        ->assertHasNoErrors();

    expect(Item::where('short_name', 'CAB-001')->value('has_dry_hire_option'))->toBeFalse();
});

test('short_name is required', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(Create::class)
        ->set('short_name', '')
        ->set('long_name', 'Ein Langname')
        ->set('description', 'Eine Beschreibung.')
        ->set('unit', 'Stk')
        ->call('save')
        ->assertHasErrors(['short_name' => 'required']);
});

test('short_name must not exceed 12 characters', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(Create::class)
        ->set('short_name', 'ABCDEFGHIJKLM') // 13 Zeichen
        ->set('long_name', 'Ein Langname')
        ->set('description', 'Eine Beschreibung.')
        ->set('unit', 'Stk')
        ->call('save')
        ->assertHasErrors(['short_name' => 'max']);
});

test('long_name is required', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(Create::class)
        ->set('short_name', 'MIC-001')
        ->set('long_name', '')
        ->set('description', 'Eine Beschreibung.')
        ->set('unit', 'Stk')
        ->call('save')
        ->assertHasErrors(['long_name' => 'required']);
});

test('long_name must not exceed 100 characters', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(Create::class)
        ->set('short_name', 'MIC-001')
        ->set('long_name', str_repeat('A', 101))
        ->set('description', 'Eine Beschreibung.')
        ->set('unit', 'Stk')
        ->call('save')
        ->assertHasErrors(['long_name' => 'max']);
});

test('description is required', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(Create::class)
        ->set('short_name', 'MIC-001')
        ->set('long_name', 'Ein Langname')
        ->set('description', '')
        ->set('unit', 'Stk')
        ->call('save')
        ->assertHasErrors(['description' => 'required']);
});

test('unit is required', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(Create::class)
        ->set('short_name', 'MIC-001')
        ->set('long_name', 'Ein Langname')
        ->set('description', 'Eine Beschreibung.')
        ->set('unit', '')
        ->call('save')
        ->assertHasErrors(['unit' => 'required']);
});

test('unit must not exceed 10 characters', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(Create::class)
        ->set('short_name', 'MIC-001')
        ->set('long_name', 'Ein Langname')
        ->set('description', 'Eine Beschreibung.')
        ->set('unit', 'ABCDEFGHIJK') // 11 Zeichen
        ->call('save')
        ->assertHasErrors(['unit' => 'max']);
});
