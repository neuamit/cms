<?php

namespace App\Services;

use App\Models\PricingPlan;
use Illuminate\Support\Facades\Http;

class SubscriptionService
{
    public function getPlan(string $plan): ?array
    {
        $record = PricingPlan::where('key', $plan)->first();
        return $record ? $this->toArray($record) : null;
    }

    public function allPlans(): array
    {
        return PricingPlan::all()->mapWithKeys(fn($p) => [$p->key => $this->toArray($p)])->toArray();
    }

    private function toArray(PricingPlan $plan): array
    {
        return ['label' => $plan->label, 'amount' => $plan->amount, 'months' => $plan->months];
    }

    public function buildPaymentPayload(string $plan, string $transactionUuid): array
    {
        $planData = $this->getPlan($plan);
        $amount = $planData['amount'];

        $signedFieldNames = 'total_amount,transaction_uuid,product_code';
        $message = "total_amount={$amount},transaction_uuid={$transactionUuid},product_code=" . config('services.esewa.merchant_code');
        $signature = base64_encode(hash_hmac('sha256', $message, config('services.esewa.secret_key'), true));

        return [
            'amount' => $amount,
            'tax_amount' => 0,
            'total_amount' => $amount,
            'transaction_uuid' => $transactionUuid,
            'product_code' => config('services.esewa.merchant_code'),
            'product_service_charge' => 0,
            'product_delivery_charge' => 0,
            'success_url' => route('subscription.success'),
            'failure_url' => route('subscription.failure'),
            'signed_field_names' => $signedFieldNames,
            'signature' => $signature,
        ];
    }

    public function verifySignature(array $data): bool
    {
        $fields = explode(',', $data['signed_field_names']);
        $message = implode(',', array_map(fn($f) => "{$f}={$data[$f]}", $fields));
        $expected = base64_encode(hash_hmac('sha256', $message, config('services.esewa.secret_key'), true));

        return hash_equals($expected, $data['signature']);
    }

    public function checkStatus(string $transactionUuid, float $totalAmount): array
    {
        $response = Http::get(config('services.esewa.status_url'), [
            'product_code' => config('services.esewa.merchant_code'),
            'total_amount' => $totalAmount,
            'transaction_uuid' => $transactionUuid,
        ]);

        return $response->json() ?? [];
    }
}