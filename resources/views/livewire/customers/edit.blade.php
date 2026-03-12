<div class="flex flex-col gap-6 max-w-2xl">

    <div class="flex items-center gap-4">
        <flux:button href="{{ route('customers.index') }}" wire:navigate variant="ghost" icon="arrow-left" />
        <flux:heading size="xl">{{ __('Kunde bearbeiten') }}: <span class="font-medium">{{ $customer->display_name }}</span></flux:heading>
    </div>

    @if (session('success'))
        <flux:callout variant="success" icon="check-circle">
            <flux:callout.heading>{{ session('success') }}</flux:callout.heading>
        </flux:callout>
    @endif

    <form wire:submit="update" class="flex flex-col gap-5">

        <flux:field>
            <flux:switch wire:model.live="is_company" label="Firmenkunde" />
        </flux:field>

        @if ($is_company)
            <flux:field>
                <flux:label>Firmenname</flux:label>
                <flux:input
                    wire:model="company_name"
                    maxlength="40"
                    placeholder="z. B. Musterfirma GmbH"
                />
                <flux:error name="company_name" />
            </flux:field>
        @else
            <div class="grid grid-cols-3 gap-4">
                <flux:field>
                    <flux:label>Anrede</flux:label>
                    <flux:select wire:model="title">
                        <flux:select.option value="">–</flux:select.option>
                        <flux:select.option value="Herr">Herr</flux:select.option>
                        <flux:select.option value="Frau">Frau</flux:select.option>
                        <flux:select.option value="Dr.">Dr.</flux:select.option>
                        <flux:select.option value="Prof.">Prof.</flux:select.option>
                        <flux:select.option value="Prof. Dr.">Prof. Dr.</flux:select.option>
                    </flux:select>
                    <flux:error name="title" />
                </flux:field>

                <flux:field>
                    <flux:label>Vorname</flux:label>
                    <flux:input
                        wire:model="name"
                        maxlength="40"
                        placeholder="Vorname"
                    />
                    <flux:error name="name" />
                </flux:field>

                <flux:field>
                    <flux:label>Nachname</flux:label>
                    <flux:input
                        wire:model="lastname"
                        maxlength="40"
                        placeholder="Nachname"
                    />
                    <flux:error name="lastname" />
                </flux:field>
            </div>
        @endif

        <div class="grid grid-cols-2 gap-4">
            <flux:field>
                <flux:label>E-Mail</flux:label>
                <flux:input
                    wire:model="email"
                    type="email"
                    placeholder="beispiel@domain.de"
                />
                <flux:error name="email" />
            </flux:field>

            <flux:field>
                <flux:label>Telefon</flux:label>
                <flux:input
                    wire:model="phone"
                    maxlength="30"
                    placeholder="+49 123 456789"
                />
                <flux:error name="phone" />
            </flux:field>
        </div>

        <flux:field>
            <flux:label>Straße und Hausnummer</flux:label>
            <flux:input
                wire:model="street"
                maxlength="100"
                placeholder="Musterstraße 1"
            />
            <flux:error name="street" />
        </flux:field>

        <div class="grid grid-cols-3 gap-4">
            <flux:field>
                <flux:label>PLZ</flux:label>
                <flux:input
                    wire:model="zip"
                    maxlength="10"
                    placeholder="12345"
                />
                <flux:error name="zip" />
            </flux:field>

            <flux:field class="col-span-2">
                <flux:label>Stadt</flux:label>
                <flux:input
                    wire:model="city"
                    maxlength="100"
                    placeholder="Musterstadt"
                />
                <flux:error name="city" />
            </flux:field>
        </div>

        @if ($is_company)
            <flux:field>
                <flux:label>USt-IdNr.</flux:label>
                <flux:input
                    wire:model="vat"
                    maxlength="30"
                    placeholder="DE123456789"
                />
                <flux:error name="vat" />
            </flux:field>
        @endif

        <div class="flex items-center gap-3">
            <flux:button type="submit" variant="primary">Änderungen speichern</flux:button>
            <flux:button href="{{ route('customers.index') }}" wire:navigate variant="ghost">Abbrechen</flux:button>
        </div>

    </form>

</div>
