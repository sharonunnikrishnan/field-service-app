<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseReceiving extends Model
{
    protected $fillable = [
        'company_id',
        'purchase_order_id',
        'received_by_user_id',
        'receiving_number',
        'received_date',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'received_date' => 'date',
        ];
    }
}
