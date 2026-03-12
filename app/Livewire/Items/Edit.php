<?php

namespace App\Livewire\Items;

use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use App\Models\ItemSet;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Item bearbeiten')]
class Edit extends Component
{
    public Item $item;

    public string $short_name = '';

    public string $long_name = '';

    public string $description = '';

    public bool $has_dry_hire_option = false;

    public string $unit = '';

    public function mount(Item $item): void
    {
        $this->item = $item;
        $this->short_name = $item->short_name;
        $this->long_name = $item->long_name;
        $this->description = $item->description;
        $this->has_dry_hire_option = $item->has_dry_hire_option;
        $this->unit = $item->unit;
    }

    public function update(): void
    {
        $validated = $this->validate((new UpdateItemRequest)->rules());

        $this->item->update($validated);

        session()->flash('success', __('Item wurde erfolgreich aktualisiert.'));

        $this->redirectRoute('items.index', navigate: true);
    }

    public function render()
    {
        $itemSets = $this->item->itemSets()->orderBy('short_name')->get();

        return view('livewire.items.edit', compact('itemSets'));
    }
}
