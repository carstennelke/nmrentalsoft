<?php

namespace App\Livewire\Customers;

use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Kunde bearbeiten')]
class Edit extends Component
{
    public Customer $customer;

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

    public function mount(Customer $customer): void
    {
        $this->customer = $customer;
        $this->is_company = $customer->is_company;
        $this->title = $customer->title ?? '';
        $this->name = $customer->name ?? '';
        $this->lastname = $customer->lastname ?? '';
        $this->company_name = $customer->company_name ?? '';
        $this->email = $customer->email ?? '';
        $this->phone = $customer->phone;
        $this->street = $customer->street;
        $this->zip = $customer->zip;
        $this->city = $customer->city;
        $this->vat = $customer->vat ?? '';
    }

    public function update(): void
    {
        $validated = $this->validate((new UpdateCustomerRequest)->rules());

        $nullable = ['title', 'name', 'lastname', 'company_name', 'email', 'vat'];
        foreach ($nullable as $field) {
            if (isset($validated[$field]) && $validated[$field] === '') {
                $validated[$field] = null;
            }
        }

        $this->customer->update($validated);

        session()->flash('success', __('Kunde wurde erfolgreich aktualisiert.'));

        $this->redirectRoute('customers.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.customers.edit');
    }
}
