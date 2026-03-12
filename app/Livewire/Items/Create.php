<?php

namespace App\Livewire\Items;

use App\Http\Requests\StoreItemRequest;
use App\Models\Item;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Item erstellen')]
class Create extends Component
{
    public string $short_name = '';

    public string $long_name = '';

    public string $description = '';

    public bool $has_dry_hire_option = false;

    public string $unit = 'Stk';

    public function save(): void
    {
        $validated = $this->validate((new StoreItemRequest)->rules());

        Item::create($validated);

        session()->flash('success', __('Item wurde erfolgreich erstellt.'));

        $this->redirectRoute('items.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.items.create');
    }
}
