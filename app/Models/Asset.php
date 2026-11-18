<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
        'company_id',
        'customer_id',
        'service_location_id',
        'name',
        'asset_type',
        'serial_number',
        'model_number',
        'manufacturer',
        'installation_date',
        'warranty_expiry_date',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'installation_date' => 'date',
            'warranty_expiry_date' => 'date',
        ];
    }
}
