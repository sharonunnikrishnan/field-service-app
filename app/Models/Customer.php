<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'company_id',
        'name',
        'email',
        'phone',
        'tax_number',
        'notes',
        'status',
    ];
}
