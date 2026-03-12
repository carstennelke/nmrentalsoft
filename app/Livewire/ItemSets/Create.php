<?php

namespace App\Livewire\ItemSets;

use App\Http\Requests\StoreItemSetRequest;
use App\Models\Item;
use App\Models\ItemSet;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Material Set erstellen')]
class Create extends Component
{
    public string $short_name = '';

    public string $long_name = '';

    public string $description = '';

    public string $unit = '';

    public string $addItemId = '';

    public int $addQuantity = 1;

    public array $selectedItems = [];

    public function addItem(): void
    {
        $this->validate([
            'addItemId' => ['required', 'exists:items,id'],
            'addQuantity' => ['required', 'integer', 'min:1'],
        ]);

        $index = collect($this->selectedItems)->search(fn ($i) => $i['item_id'] == $this->addItemId);

        if ($index !== false) {
            $this->selectedItems[$index]['quantity'] += $this->addQuantity;
        } else {
            $this->selectedItems[] = [
                'item_id' => (int) $this->addItemId,
                'quantity' => $this->addQuantity,
            ];
        }

        $this->addItemId = '';
        $this->addQuantity = 1;
    }

    public function removeItem(int $index): void
    {
        array_splice($this->selectedItems, $index, 1);
    }

    public function save(): void
    {
        $validated = $this->validate(array_merge(
            (new StoreItemSetRequest)->rules(),
            [
                'selectedItems' => ['array'],
                'selectedItems.*.item_id' => ['required', 'exists:items,id'],
                'selectedItems.*.quantity' => ['required', 'integer', 'min:1'],
            ]
        ));

        $itemSet = ItemSet::create([
            'short_name' => $validated['short_name'],
            'long_name' => $validated['long_name'],
            'description' => $validated['description'] ?: null,
            'unit' => $validated['unit'],
        ]);

        $syncData = collect($this->selectedItems)
            ->mapWithKeys(fn ($row) => [$row['item_id'] => ['quantity' => $row['quantity']]])
            ->toArray();

        $itemSet->items()->sync($syncData);

        session()->flash('success', __('Material Set wurde erfolgreich erstellt.'));

        $this->redirectRoute('item-sets.index', navigate: true);
    }

    public function render()
    {
        $items = Item::orderBy('short_name')->get();

        return view('livewire.item-sets.create', compact('items'));
    }
}
