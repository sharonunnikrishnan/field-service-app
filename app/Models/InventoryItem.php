<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    protected $fillable = [
        'company_id',
        'name',
        'sku',
        'unit',
        'current_quantity',
        'minimum_quantity',
        'unit_cost',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'current_quantity' => 'decimal:2',
            'minimum_quantity' => 'decimal:2',
            'unit_cost' => 'decimal:2',
        ];
    }

}
