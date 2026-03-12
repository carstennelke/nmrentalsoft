<?php

namespace App\Livewire\Items;

use App\Models\Item;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Items')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        Item::findOrFail($id)->delete();
        session()->flash('success', __('Item wurde erfolgreich gelöscht.'));
    }

    public function render()
    {
        $items = Item::query()
            ->when($this->search, fn ($q) => $q
                ->where('short_name', 'like', "%{$this->search}%")
                ->orWhere('long_name', 'like', "%{$this->search}%")
            )
            ->orderBy('long_name')
            ->paginate(15);

        return view('livewire.items.index', compact('items'));
    }
}
