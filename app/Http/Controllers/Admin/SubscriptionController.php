<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Restaurant;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubscriptionController extends Controller
{
    public function show(SubscriptionService $service)
    {
        $restaurant = Restaurant::where('owner_id', auth()->id())->firstOrFail();
        $plans = $service->allPlans();
        return view('admin.subscription.show', compact('restaurant', 'plans'));
    }

    public function claimTrial(Request $request)
    {
        $restaurant = Restaurant::where('owner_id', auth()->id())->firstOrFail();

        if ($restaurant->trial_claimed) {
            return back()->with('error', 'You have already used your free trial.');
        }

        $restaurant->update([
            'trial_claimed' => true,
            'trial_ends_at' => now()->addMonths(3),
            'subscription_status' => 'trial',
        ]);

        return redirect()->route('admin.subscription.show')->with('success', 'Your 3-month free trial is now active!');
    }

    public function initiate(Request $request, SubscriptionService $service)
    {
        $request->validate(['plan' => 'required|in:monthly,yearly']);
        $restaurant = Restaurant::where('owner_id', auth()->id())->firstOrFail();

        $transactionUuid = (string) Str::uuid();
        $planData = $service->getPlan($request->plan);

        Payment::create([
            'restaurant_id' => $restaurant->_id,
            'plan' => $request->plan,
            'amount' => $planData['amount'],
            'transaction_uuid' => $transactionUuid,
            'status' => 'pending',
        ]);

        $payload = $service->buildPaymentPayload($request->plan, $transactionUuid);

        return view('admin.subscription.redirect', [
            'paymentUrl' => config('services.esewa.payment_url'),
            'payload' => $payload,
        ]);
    }

    public function success(Request $request, SubscriptionService $service)
    {
        $decoded = json_decode(base64_decode($request->query('data')), true);

        if (!$decoded || !$service->verifySignature($decoded)) {
            return redirect()->route('admin.subscription.show')->with('error', 'Payment verification failed.');
        }

        $payment = Payment::where('transaction_uuid', $decoded['transaction_uuid'])->first();
        if (!$payment) {
            return redirect()->route('admin.subscription.show')->with('error', 'Transaction not found.');
        }

        $status = $service->checkStatus($decoded['transaction_uuid'], $decoded['total_amount']);

        if (($status['status'] ?? null) !== 'COMPLETE') {
            $payment->update(['status' => 'failed', 'raw_response' => json_encode($status)]);
            return redirect()->route('admin.subscription.show')->with('error', 'Payment could not be verified.');
        }

        $payment->update([
            'status' => 'completed',
            'esewa_ref_id' => $decoded['transaction_code'] ?? null,
            'raw_response' => json_encode($decoded),
        ]);

        $restaurant = Restaurant::find($payment->restaurant_id);
        $planData = $service->getPlan($payment->plan);

        $currentExpiry = $restaurant->subscription_expires_at && $restaurant->subscription_expires_at->isFuture()
            ? $restaurant->subscription_expires_at
            : now();

        $restaurant->update([
            'subscription_status' => 'active',
            'subscription_plan' => $payment->plan,
            'subscription_expires_at' => $currentExpiry->copy()->addMonths($planData['months']),
        ]);

        return redirect()->route('admin.subscription.show')->with('success', 'Subscription activated!');
    }

    public function failure()
    {
        return redirect()->route('admin.subscription.show')->with('error', 'Payment was cancelled or failed.');
    }
}