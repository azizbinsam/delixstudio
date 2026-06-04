<?php

namespace Database\Seeders;

use App\Models\PaymentSetting;
use Illuminate\Database\Seeder;

class PaymentSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentSetting::create([
            'midtrans_active' => false,
            'midtrans_server_key' => null,
            'midtrans_client_key' => null,
            'midtrans_production' => false,
            'manual_transfer_active' => true,
            'bank_name' => 'BCA',
            'bank_account_number' => '1234567890',
            'bank_account_name' => 'Delix Studio',
            'whatsapp_number' => '08123456789',
        ]);
    }
}
