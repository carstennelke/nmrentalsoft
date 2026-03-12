<div class="flex flex-col gap-6 max-w-2xl">

    <div class="flex items-center gap-4">
        <flux:button href="{{ route('items.index') }}" wire:navigate variant="ghost" icon="arrow-left" />
        <flux:heading size="xl">{{ __('Neues Material erstellen') }}</flux:heading>
    </div>

    <form wire:submit="save" class="flex flex-col gap-5">

        <div class="grid grid-cols-2 gap-4">
            <flux:field>
                <flux:label>Kurzname <flux:badge size="sm" class="ms-2">max. 12 Zeichen</flux:badge></flux:label>
                <flux:input
                    wire:model="short_name"
                    maxlength="12"
                    placeholder="z. B. MIC-001"
                    autofocus
                />
                <flux:error name="short_name" />
            </flux:field>

            <flux:field>
                <flux:label>Einheit <flux:badge size="sm" class="ms-2">max. 10 Zeichen</flux:badge></flux:label>
                <flux:input
                    wire:model="unit"
                    maxlength="10"
                    placeholder="z. B. Stk, Tag, Set"
                />
                <flux:error name="unit" />
            </flux:field>
        </div>

        <flux:field>
            <flux:label>Langname</flux:label>
            <flux:input
                wire:model="long_name"
                maxlength="100"
                placeholder="Vollständige Bezeichnung"
            />
            <flux:error name="long_name" />
        </flux:field>

        <flux:field>
            <flux:label>Beschreibung</flux:label>
            <flux:textarea
                wire:model="description"
                rows="4"
                placeholder="Detaillierte Beschreibung des Items"
            />
            <flux:error name="description" />
        </flux:field>

        <flux:field>
            <flux:checkbox wire:model="has_dry_hire_option" label="Dry-Hire-Option verfügbar" />
            <flux:error name="has_dry_hire_option" />
        </flux:field>

        <div class="flex items-center gap-3">
            <flux:button type="submit" variant="primary">Speichern</flux:button>
            <flux:button href="{{ route('items.index') }}" wire:navigate variant="ghost">Abbrechen</flux:button>
        </div>

    </form>

</div>
