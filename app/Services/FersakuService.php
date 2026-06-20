<?php

namespace App\Services;

use App\Models\PaymentSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FersakuService
{
    protected string $baseUrl = 'https://fersaku.com/api/v1';
    protected ?string $apiKey;

    public function __construct()
    {
        $setting = PaymentSetting::first();
        $this->apiKey = $setting?->fersaku_api_key;
    }

    public function createPayment(array $params): ?array
    {
        $response = Http::withToken($this->apiKey)
            ->timeout(15)
            ->post("{$this->baseUrl}/payments", $params);

        if (! $response->successful()) {
            Log::error('Fersaku createPayment failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            return null;
        }

        return $response->json();
    }

    public function getPayment(string $id): ?array
    {
        $response = Http::withToken($this->apiKey)
            ->get("{$this->baseUrl}/payments/{$id}");

        return $response->successful() ? $response->json() : null;
    }

    public function cancelPayment(string $id): bool
    {
        $response = Http::withToken($this->apiKey)
            ->post("{$this->baseUrl}/payments/{$id}/cancel");

        return $response->successful();
    }

    public function checkStatus(string $id): ?array
    {
        $response = Http::withToken($this->apiKey)
            ->post("{$this->baseUrl}/payments/{$id}/check-status");

        return $response->successful() ? $response->json() : null;
    }

    public static function verifySignature(string $rawBody, ?string $signature, string $secret): bool
    {
        if (empty($signature)) {
            return false;
        }

        $expected = hash_hmac('sha256', $rawBody, $secret);

        return hash_equals($expected, $signature);
    }

public function getCheckoutUrl(string $paymentId): ?string
{
    $payment = $this->getPayment($paymentId);

    if (! $payment) {
        return null;
    }

    // Kalau sudah expired/paid/failed, tidak ada checkout_url yang valid
    if (! in_array($payment['status'], ['pending'])) {
        return null;
    }

    return $payment['checkout_url'] ?? null;
}
}
