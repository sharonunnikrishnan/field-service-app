<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorInvoicePayment extends Model
{
    protected $fillable = [
        'company_id',
        'vendor_invoice_id',
        'payment_date',
        'amount',
        'payment_method',
        'reference',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'payment_date' => 'date',
            'amount' => 'decimal:2',
        ];
    }
}
