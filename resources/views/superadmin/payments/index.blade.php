@extends('layouts.admin')
@section('title', 'Payments & Revenue')
@section('content')

<div class="row">
    <div class="col-md-3 col-6">
        <div class="small-box bg-success">
            <div class="inner"><h3>Rs. {{ number_format($totalRevenue) }}</h3><p>Total Revenue</p></div>
            <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="small-box bg-info">
            <div class="inner"><h3>Rs. {{ number_format($revenueThisMonth) }}</h3><p>This Month</p></div>
            <div class="icon"><i class="fas fa-calendar"></i></div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner"><h3>{{ $completedCount }}</h3><p>Completed</p></div>
            <div class="icon"><i class="fas fa-check-circle"></i></div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner"><h3>{{ $failedCount }}</h3><p>Failed</p></div>
            <div class="icon"><i class="fas fa-times-circle"></i></div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header"><h5 class="mb-0">All Transactions ({{ $totalTransactions }})</h5></div>
    <div class="card-body">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Restaurant</th>
                    <th>Plan</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>eSewa Ref ID</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                @php $restaurant = $restaurants->get((string) $payment->restaurant_id); @endphp
                <tr>
                    <td>{{ $payment->created_at?->format('M d, Y H:i') }}</td>
                    <td>{{ $restaurant->name ?? '—' }}</td>
                    <td>{{ ucfirst($payment->plan) }}</td>
                    <td>Rs. {{ number_format($payment->amount) }}</td>
                    <td>
                        @if($payment->status === 'completed')
                            <span class="badge badge-success">Completed</span>
                        @elseif($payment->status === 'failed')
                            <span class="badge badge-danger">Failed</span>
                        @else
                            <span class="badge badge-warning">Pending</span>
                        @endif
                    </td>
                    <td><small class="text-muted">{{ $payment->esewa_ref_id ?? '—' }}</small></td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center">No transactions yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection