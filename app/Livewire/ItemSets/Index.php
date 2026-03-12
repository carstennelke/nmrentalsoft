<?php

namespace App\Livewire\ItemSets;

use App\Models\ItemSet;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Material Sets')]
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
        ItemSet::findOrFail($id)->delete();
        session()->flash('success', __('Material Set wurde erfolgreich gelöscht.'));
    }

    public function render()
    {
        $itemSets = ItemSet::query()
            ->withCount('items')
            ->when($this->search, fn ($q) => $q
                ->where('short_name', 'like', "%{$this->search}%")
                ->orWhere('long_name', 'like', "%{$this->search}%")
            )
            ->orderBy('short_name')
            ->paginate(15);

        return view('livewire.item-sets.index', compact('itemSets'));
    }
}
