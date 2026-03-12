<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\ItemSet;
use Illuminate\Database\Seeder;

class ItemSetSeeder extends Seeder
{
    public function run(): void
    {
        $items = Item::all();

        ItemSet::factory()->count(8)->create()->each(function (ItemSet $itemSet) use ($items) {
            $randomItems = $items->random(min(rand(2, 6), $items->count()));

            $syncData = $randomItems->mapWithKeys(fn ($item) => [
                $item->id => ['quantity' => rand(1, 10)],
            ])->toArray();

            $itemSet->items()->sync($syncData);
        });
    }
}
