@extends('layouts.admin')
@section('title', 'Subscription')
@section('content')

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

<div class="card mb-3">
    <div class="card-body">
        <h5>Current Status</h5>

        @if($restaurant->subscription_status === 'active' && $restaurant->subscription_expires_at?->isFuture())
            <p class="text-success">Active ({{ ucfirst($restaurant->subscription_plan) }} plan) — expires {{ $restaurant->subscription_expires_at->format('M d, Y') }}</p>

        @elseif($restaurant->subscription_status === 'trial' && $restaurant->trial_ends_at?->isFuture())
            <p class="text-info">Free trial active — ends {{ $restaurant->trial_ends_at->format('M d, Y') }}</p>

        @else
            <p class="text-danger">No active plan. Your menu is currently hidden from customers.</p>
        @endif

        @if(!$restaurant->trial_claimed)
            <form method="POST" action="{{ route('admin.subscription.claim-trial') }}" class="mt-2">
                @csrf
                <button class="btn btn-outline-success">Claim Your Free 3-Month Trial</button>
            </form>
        @else
            <p class="text-muted small mt-2">Free trial already used.</p>
        @endif
    </div>
</div>

<div class="row">
    @foreach($plans as $key => $plan)
    <div class="col-md-6">
        <div class="card">
            <div class="card-body text-center">
                <h5>{{ $plan['label'] }}</h5>
                <h3>Rs. {{ $plan['amount'] }}</h3>
                <form method="POST" action="{{ route('admin.subscription.initiate') }}">
                    @csrf
                    <input type="hidden" name="plan" value="{{ $key }}">
                    <button class="btn btn-primary">Pay with eSewa</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection