<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceReport extends Model
{
    protected $fillable = [
        'company_id',
        'work_order_id',
        'created_by_user_id',
        'report_date',
        'description',
        'findings',
        'work_performed',
        'recommendations',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'report_date' => 'date',
        ];
    }
}
