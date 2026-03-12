<div class="flex flex-col gap-6">

    <div class="flex items-center justify-between">
        <flux:heading size="xl">{{ __('Items') }}</flux:heading>
        <flux:button href="{{ route('items.create') }}" wire:navigate icon="plus">
            {{ __('Neues Item') }}
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
            <thead class="bg-zinc-50 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 text-left">
                <tr>
                    <th class="px-4 py-3 font-medium">Kurzname</th>
                    <th class="px-4 py-3 font-medium">Langname</th>
                    <th class="px-4 py-3 font-medium">Einheit</th>
                    <th class="px-4 py-3 font-medium">Dry Hire</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                @forelse ($items as $item)
                    <tr
                        class="bg-white dark:bg-zinc-900 hover:bg-zinc-50 dark:hover:bg-zinc-800 cursor-pointer"
                        wire:navigate
                        onclick="window.location='{{ route('items.edit', $item) }}'"
                    >
                        <td class="px-4 py-3 font-mono font-medium text-zinc-900 dark:text-zinc-100">
                            {{ $item->short_name }}
                        </td>
                        <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">
                            {{ $item->long_name }}
                        </td>
                        <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">
                            {{ $item->unit }}
                        </td>
                        <td class="px-4 py-3">
                            @if ($item->has_dry_hire_option)
                                <flux:badge color="green" size="sm">Ja</flux:badge>
                            @else
                                <flux:badge color="zinc" size="sm">Nein</flux:badge>
                            @endif
                        </td>
                        <td class="px-4 py-3" onclick="event.stopPropagation()">
                            <div class="flex items-center justify-end gap-2">
                                <flux:button
                                    href="{{ route('items.edit', $item) }}"
                                    wire:navigate
                                    size="sm"
                                    variant="ghost"
                                    color="green"
                                    icon="pencil-square"
                                >

                                </flux:button>
                                <flux:button
                                    wire:click="delete({{ $item->id }})"
                                    wire:confirm="{{ __('Material') }} '{{ $item->short_name }}' wirklich löschen?"
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
                            {{ __('Keine Items gefunden.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $items->links() }}
    </div>

</div>
