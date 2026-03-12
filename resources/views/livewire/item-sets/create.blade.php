<div class="flex flex-col gap-6 max-w-3xl">

    <div class="flex items-center gap-4">
        <flux:button href="{{ route('item-sets.index') }}" wire:navigate variant="ghost" icon="arrow-left" />
        <flux:heading size="xl">{{ __('Neues Material Set erstellen') }}</flux:heading>
    </div>

    <form wire:submit="save" class="flex flex-col gap-5">

        <div class="grid grid-cols-2 gap-4">
            <flux:field>
                <flux:label>Kurzname <flux:badge size="sm" class="ms-2">max. 12 Zeichen</flux:badge></flux:label>
                <flux:input
                    wire:model="short_name"
                    maxlength="12"
                    placeholder="z. B. SET-001"
                    autofocus
                />
                <flux:error name="short_name" />
            </flux:field>

            <flux:field>
                <flux:label>Einheit <flux:badge size="sm" class="ms-2">max. 10 Zeichen</flux:badge></flux:label>
                <flux:input
                    wire:model="unit"
                    maxlength="10"
                    placeholder="z. B. Set, Paket"
                />
                <flux:error name="unit" />
            </flux:field>
        </div>

        <flux:field>
            <flux:label>Bezeichnung</flux:label>
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
                rows="3"
                placeholder="Optionale Beschreibung des Material Sets"
            />
            <flux:error name="description" />
        </flux:field>

        {{-- Item-Auswahl --}}
        <div class="flex flex-col gap-3 rounded-lg border border-zinc-200 dark:border-zinc-700 p-4">
            <flux:heading size="sm">Positionen</flux:heading>

            {{-- Hinzufügen-Zeile --}}
            <div class="flex items-end gap-3">
                <flux:field class="flex-1">
                    <flux:label>Item</flux:label>
                    <flux:select wire:model="addItemId" placeholder="Item wählen...">
                        @foreach ($items as $item)
                            <flux:select.option value="{{ $item->id }}">
                                {{ $item->short_name }} – {{ $item->long_name }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:error name="addItemId" />
                </flux:field>

                <flux:field class="w-28">
                    <flux:label>Menge</flux:label>
                    <flux:input wire:model="addQuantity" type="number" min="1" />
                    <flux:error name="addQuantity" />
                </flux:field>

                <flux:button wire:click.prevent="addItem" icon="plus" variant="outline">
                    Hinzufügen
                </flux:button>
            </div>

            {{-- Liste der gewählten Items --}}
            @if (count($selectedItems) > 0)
                <div class="overflow-x-auto rounded border border-zinc-200 dark:border-zinc-700 mt-2">
                    <table class="w-full text-sm">
                        <thead class="bg-zinc-50 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 text-left">
                            <tr>
                                <th class="px-3 py-2 font-medium">Artikel-Nr.</th>
                                <th class="px-3 py-2 font-medium">Bezeichnung</th>
                                <th class="px-3 py-2 font-medium text-right">Menge</th>
                                <th class="px-3 py-2"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @foreach ($selectedItems as $index => $row)
                                @php $item = $items->firstWhere('id', $row['item_id']); @endphp
                                <tr class="bg-white dark:bg-zinc-900">
                                    <td class="px-3 py-2 font-mono text-zinc-900 dark:text-zinc-100">
                                        {{ $item?->short_name }}
                                    </td>
                                    <td class="px-3 py-2 text-zinc-700 dark:text-zinc-300">
                                        {{ $item?->long_name }}
                                    </td>
                                    <td class="px-3 py-2 text-right text-zinc-700 dark:text-zinc-300">
                                        {{ $row['quantity'] }}
                                    </td>
                                    <td class="px-3 py-2 text-right">
                                        <flux:button
                                            wire:click.prevent="removeItem({{ $index }})"
                                            size="sm"
                                            variant="ghost"
                                            icon="trash"
                                        />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-sm text-zinc-400 dark:text-zinc-500 text-center py-4">
                    Noch keine Items hinzugefügt.
                </p>
            @endif
        </div>

        <div class="flex items-center gap-3">
            <flux:button type="submit" variant="primary">Speichern</flux:button>
            <flux:button href="{{ route('item-sets.index') }}" wire:navigate variant="ghost">Abbrechen</flux:button>
        </div>

    </form>

</div>
