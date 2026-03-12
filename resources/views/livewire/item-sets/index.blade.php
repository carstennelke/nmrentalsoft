<div class="flex flex-col gap-6">

    <div class="flex items-center justify-between">
        <flux:heading size="xl">{{ __('Material Sets') }}</flux:heading>
        <flux:button href="{{ route('item-sets.create') }}" wire:navigate icon="plus">
            {{ __('Neues Material Set') }}
        </flux:button>
    </div>

    @if (session('success'))
        <flux:callout variant="success" icon="check-circle">
            <flux:callout.heading>{{ session('success') }}</flux:callout.heading>
        </flux:callout>
    @endif

    <div>
        <flux:input
            wire:model.live.debounce.300ms="search"
            placeholder="Suchen..."
            icon="magnifying-glass"
            class="max-w-xs"
        />
    </div>

    <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700">
        <table class="w-full text-sm">
            <thead class="bg-[#F39200] text-white text-left">
                <tr>
                    <th class="px-4 py-3 font-medium">Kurzname</th>
                    <th class="px-4 py-3 font-medium">Bezeichnung</th>
                    <th class="px-4 py-3 font-medium">Einheit</th>
                    <th class="px-4 py-3 font-medium">Positionen</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                @forelse ($itemSets as $itemSet)
                    <tr
                        class="bg-white dark:bg-zinc-900 hover:bg-zinc-50 dark:hover:bg-zinc-800 cursor-pointer"
                        wire:navigate
                        onclick="window.location='{{ route('item-sets.edit', $itemSet) }}'"
                    >
                        <td class="px-4 py-3 font-mono font-medium text-zinc-900 dark:text-zinc-100">
                            {{ $itemSet->short_name }}
                        </td>
                        <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">
                            {{ $itemSet->long_name }}
                        </td>
                        <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">
                            {{ $itemSet->unit }}
                        </td>
                        <td class="px-4 py-3">
                            <flux:badge color="zinc" size="sm">{{ $itemSet->items_count }} {{ __('Items') }}</flux:badge>
                        </td>
                        <td class="px-4 py-3" onclick="event.stopPropagation()">
                            <div class="flex items-center justify-end gap-2">
                                <flux:button
                                    href="{{ route('item-sets.edit', $itemSet) }}"
                                    wire:navigate
                                    size="sm"
                                    variant="ghost"
                                    color="green"
                                    icon="pencil-square"
                                >
                                </flux:button>
                                <flux:button
                                    wire:click="delete({{ $itemSet->id }})"
                                    wire:confirm="{{ __('Material Set') }} \'{{ $itemSet->short_name }}\' wirklich löschen?"
                                    size="sm"
                                    variant="ghost"
                                    icon="trash"
                                >
                                </flux:button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-zinc-500 dark:text-zinc-400">
                            {{ __('Keine Material Sets gefunden.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $itemSets->links() }}
    </div>

</div>
