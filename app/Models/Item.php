<?php

namespace App\Models;

use Database\Factories\ItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    /** @use HasFactory<ItemFactory> */
    use HasFactory;

    protected $fillable = [
        'short_name',
        'long_name',
        'description',
        'has_dry_hire_option',
        'unit',
    ];

    protected function casts(): array
    {
        return [
            'has_dry_hire_option' => 'boolean',
        ];
    }

    public function itemSets(): BelongsToMany
    {
        return $this->belongsToMany(ItemSet::class)->withPivot('quantity');
    }
}
