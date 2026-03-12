<?php

namespace App\Livewire\Customers;

use App\Http\Requests\StoreCustomerRequest;
use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Kunde erstellen')]
class Create extends Component
{
    public bool $is_company = false;

    public string $title = '';

    public string $name = '';

    public string $lastname = '';

    public string $company_name = '';

    public string $email = '';

    public string $phone = '';

    public string $street = '';

    public string $zip = '';

    public string $city = '';

    public string $vat = '';

    public function save(): void
    {
        $validated = $this->validate((new StoreCustomerRequest)->rules());

        $nullable = ['title', 'name', 'lastname', 'company_name', 'email', 'vat'];
        foreach ($nullable as $field) {
            if (isset($validated[$field]) && $validated[$field] === '') {
                $validated[$field] = null;
            }
        }

        Customer::create($validated);

        session()->flash('success', __('Kunde wurde erfolgreich erstellt.'));

        $this->redirectRoute('customers.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.customers.create');
    }
}
