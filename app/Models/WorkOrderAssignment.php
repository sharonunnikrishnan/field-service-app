<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrderAssignment extends Model
{
    protected $fillable = [
        'company_id',
        'work_order_id',
        'user_id',
        'scheduled_start',
        'scheduled_end',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_start' => 'datetime',
            'scheduled_end' => 'datetime',
        ];
    }
}
