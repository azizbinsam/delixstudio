<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payment_settings', function (Blueprint $table) {
            $table->boolean('fersaku_active')->default(false)->after('manual_transfer_active');
            $table->string('fersaku_api_key')->nullable()->after('fersaku_active');
            $table->string('fersaku_webhook_secret')->nullable()->after('fersaku_api_key');
            $table->boolean('fersaku_sandbox')->default(true)->after('fersaku_webhook_secret');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_settings', function (Blueprint $table) {
            $table->dropColumn(['fersaku_active', 'fersaku_api_key', 'fersaku_webhook_secret', 'fersaku_sandbox']);
        });
    }
};
