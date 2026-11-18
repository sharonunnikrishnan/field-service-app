<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseReceivingItem extends Model
{
    protected $fillable = [
        'purchase_receiving_id',
        'purchase_order_item_id',
        'inventory_item_id',
        'quantity_received',
        'unit_cost',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'quantity_received' => 'decimal:2',
            'unit_cost' => 'decimal:2',
        ];
    }
}
