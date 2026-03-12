<div class="flex flex-col gap-6 max-w-2xl">

    <div class="flex items-center gap-4">
        <flux:button href="{{ route('items.index') }}" wire:navigate variant="ghost" icon="arrow-left" />
        <flux:heading size="xl">{{ __('Item bearbeiten') }}: <span class="font-mono">{{ $item->short_name }}</span></flux:heading>
    </div>

    @if (session('success'))
        <flux:callout variant="success" icon="check-circle">
            <flux:callout.heading>{{ session('success') }}</flux:callout.heading>
        </flux:callout>
    @endif

    <div x-data="{ tab: 'details' }">

        {{-- Tab-Navigation --}}
        <div class="flex border-b border-zinc-200 dark:border-zinc-700">
            <button
                type="button"
                @click="tab = 'details'"
                :class="tab === 'details'
                    ? 'border-b-2 border-zinc-900 dark:border-zinc-100 text-zinc-900 dark:text-zinc-100'
                    : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200'"
                class="px-4 py-2 text-sm font-medium transition-colors"
            >Stammdaten</button>
            <button
                type="button"
                @click="tab = 'sets'"
                :class="tab === 'sets'
                    ? 'border-b-2 border-zinc-900 dark:border-zinc-100 text-zinc-900 dark:text-zinc-100'
                    : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200'"
                class="px-4 py-2 text-sm font-medium transition-colors flex items-center gap-2"
            >
                In
                <span class="inline-flex items-center rounded-full bg-zinc-100 dark:bg-zinc-700 px-2 py-0.5 text-xs font-medium text-zinc-600 dark:text-zinc-300">
                    {{ $itemSets->count() }}
                </span> Sets vorhanden
            </button>
        </div>

        {{-- Tab: Stammdaten --}}
        <div x-show="tab === 'details'" x-cloak>
            <form wire:submit="update" class="flex flex-col gap-5 pt-5">

                <div class="grid grid-cols-2 gap-4">
                    <flux:field>
                        <flux:label>{{ __('Artikelnummer') }} <flux:badge size="sm" class="ms-2">max. 12 Zeichen</flux:badge></flux:label>
                        <flux:input
                            wire:model="short_name"
                            maxlength="12"
                            placeholder="z. B. MIC-001"
                        />
                        <flux:error name="short_name" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Einheit</flux:label>
                        <flux:select wire:model="unit">
                            <flux:select.option value="Stk">Stk</flux:select.option>
                            <flux:select.option value="m">m</flux:select.option>
                            <flux:select.option value="pauschal">pauschal</flux:select.option>
                            <flux:select.option value="km">km</flux:select.option>
                            <flux:select.option value="Tag(e)">Tag(e)</flux:select.option>
                        </flux:select>
                        <flux:error name="unit" />
                    </flux:field>
                </div>

                <flux:field>
                    <flux:label>{{ __('Bezeichnung') }}</flux:label>
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
                    <flux:checkbox wire:model="has_dry_hire_option" label="ist zumietbar (Dry-Hire)" />
                    <flux:error name="has_dry_hire_option" />
                </flux:field>

                <div class="flex items-center gap-3">
                    <flux:button type="submit" variant="primary">Änderungen speichern</flux:button>
                    <flux:button href="{{ route('items.index') }}" wire:navigate variant="ghost">Abbrechen</flux:button>
                </div>

            </form>
        </div>

        {{-- Tab: Material Sets --}}
        <div x-show="tab === 'sets'" x-cloak class="pt-5">
            @if ($itemSets->isEmpty())
                <p class="text-sm text-zinc-400 dark:text-zinc-500 text-center py-8">
                    Dieses Item ist in keinem Material Set enthalten.
                </p>
            @else
                <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700">
                    <table class="w-full text-sm">
                        <thead class="bg-[#F39200] text-white text-left">
                            <tr>
                                <th class="px-4 py-3 font-medium">Kurzname</th>
                                <th class="px-4 py-3 font-medium">Bezeichnung</th>
                                <th class="px-4 py-3 font-medium">Einheit</th>
                                <th class="px-4 py-3 font-medium text-right">Menge</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @foreach ($itemSets as $itemSet)
                                <tr class="bg-white dark:bg-zinc-900 hover:bg-zinc-50 dark:hover:bg-zinc-800">
                                    <td class="px-4 py-3 font-mono font-medium text-zinc-900 dark:text-zinc-100">
                                        {{ $itemSet->short_name }}
                                    </td>
                                    <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">
                                        {{ $itemSet->long_name }}
                                    </td>
                                    <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">
                                        {{ $itemSet->unit }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-zinc-700 dark:text-zinc-300">
                                        {{ $itemSet->pivot->quantity }}
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <flux:button
                                            href="{{ route('item-sets.edit', $itemSet) }}"
                                            wire:navigate
                                            size="sm"
                                            variant="ghost"
                                            color="green"
                                            icon="pencil-square"
                                        />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>

</div>
