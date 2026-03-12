<?php

namespace App\Models;

use Database\Factories\CustomerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /** @use HasFactory<CustomerFactory> */
    use HasFactory;

    protected $fillable = [
        'is_company',
        'title',
        'name',
        'lastname',
        'company_name',
        'email',
        'phone',
        'street',
        'zip',
        'city',
        'vat',
    ];

    protected function casts(): array
    {
        return [
            'is_company' => 'boolean',
        ];
    }

    public function getDisplayNameAttribute(): string
    {
        if ($this->is_company) {
            return $this->company_name ?? $this->name . ' ' . $this->lastname;
        }

        return implode(' ', array_filter([$this->title, $this->name, $this->lastname]));
    }
}
