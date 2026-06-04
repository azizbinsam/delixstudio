<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'midtrans_active',
        'midtrans_server_key',
        'midtrans_client_key',
        'midtrans_production',
        'manual_transfer_active',
        'bank_name',
        'bank_account_number',
        'bank_account_name',
        'whatsapp_number',
    ];

    protected function casts(): array
    {
        return [
            'midtrans_active' => 'boolean',
            'midtrans_production' => 'boolean',
            'manual_transfer_active' => 'boolean',
        ];
    }
}
