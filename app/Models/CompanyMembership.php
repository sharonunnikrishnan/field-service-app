<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyMembership extends Model
{
    protected $fillable = [
        'company_id',
        'user_id',
        'role_id',
    ];
}
