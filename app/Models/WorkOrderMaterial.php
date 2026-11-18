<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrderMaterial extends Model
{
    protected $fillable = [
        'company_id',
        'work_order_id',
        'inventory_item_id',
        'quantity',
        'unit_cost',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
            'unit_cost' => 'decimal:2',
        ];
    }
}
