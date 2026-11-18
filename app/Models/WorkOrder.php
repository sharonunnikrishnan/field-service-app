<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    protected $fillable = [
        'company_id',
        'customer_id',
        'service_location_id',
        'service_id',
        'quotation_id',
        'asset_id',
        'created_by_user_id',
        'title',
        'description',
        'priority',
        'status',
        'scheduled_start',
        'scheduled_end',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_start' => 'datetime',
            'scheduled_end' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }
}
