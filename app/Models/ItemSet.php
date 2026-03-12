<?php

namespace App\Models;

use Database\Factories\ItemSetFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ItemSet extends Model
{
    /** @use HasFactory<ItemSetFactory> */
    use HasFactory;

    protected $fillable = [
        'short_name',
        'long_name',
        'description',
        'unit',
    ];

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class)->withPivot('quantity');
    }
}
