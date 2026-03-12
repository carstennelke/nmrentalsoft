<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Kunden')]
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
        Customer::findOrFail($id)->delete();
        session()->flash('success', __('Kunde wurde erfolgreich gelöscht.'));
    }

    public function render()
    {
        $customers = Customer::query()
            ->when($this->search, fn ($q) => $q
                ->where('company_name', 'like', "%{$this->search}%")
                ->orWhere('name', 'like', "%{$this->search}%")
                ->orWhere('lastname', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%")
                ->orWhere('city', 'like', "%{$this->search}%")
            )
            ->orderBy('company_name')
            ->orderBy('lastname')
            ->paginate(15);

        return view('livewire.customers.index', compact('customers'));
    }
}
