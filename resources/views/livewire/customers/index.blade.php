<div class="flex flex-col gap-6">

    <div class="flex items-center justify-between">
        <flux:heading size="xl">{{ __('Kunden') }}</flux:heading>
        <flux:button href="{{ route('customers.create') }}" wire:navigate icon="plus">
            {{ __('Neuer Kunde') }}
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
                    <th class="px-4 py-3 font-medium">Typ</th>
                    <th class="px-4 py-3 font-medium">Name</th>
                    <th class="px-4 py-3 font-medium">E-Mail</th>
                    <th class="px-4 py-3 font-medium">Telefon</th>
                    <th class="px-4 py-3 font-medium">Ort</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                @forelse ($customers as $customer)
                    <tr
                        class="bg-white dark:bg-zinc-900 hover:bg-zinc-50 dark:hover:bg-zinc-800 cursor-pointer"
                        wire:navigate
                        onclick="window.location='{{ route('customers.edit', $customer) }}'"
                    >
                        <td class="px-4 py-3">
                            @if ($customer->is_company)
                                <flux:badge color="blue" size="sm">Firma</flux:badge>
                            @else
                                <flux:badge color="zinc" size="sm">Privat</flux:badge>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-medium text-zinc-900 dark:text-zinc-100">
                            {{ $customer->display_name }}
                        </td>
                        <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">
                            {{ $customer->email ?? '–' }}
                        </td>
                        <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">
                            {{ $customer->phone }}
                        </td>
                        <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">
                            {{ $customer->city }}
                        </td>
                        <td class="px-4 py-3" onclick="event.stopPropagation()">
                            <div class="flex items-center justify-end gap-2">
                                <flux:button
                                    href="{{ route('customers.edit', $customer) }}"
                                    wire:navigate
                                    size="sm"
                                    variant="ghost"
                                    color="green"
                                    icon="pencil-square"
                                >
                                </flux:button>
                                <flux:button
                                    wire:click="delete({{ $customer->id }})"
                                    wire:confirm="{{ __('Kunde') }} '{{ $customer->display_name }}' wirklich löschen?"
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
                        <td colspan="6" class="px-4 py-10 text-center text-zinc-500 dark:text-zinc-400">
                            {{ __('Keine Kunden gefunden.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $customers->links() }}
    </div>

</div>
