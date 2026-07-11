@extends('layouts.admin')
@section('title', $restaurant->name . ' - Stats')
@section('content')

<a href="{{ route('superadmin.restaurants') }}" class="btn btn-sm btn-secondary mb-3">&larr; Back to All Restaurants</a>

<div class="card mb-3">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-0">{{ $restaurant->name }}</h4>
            <p class="text-muted mb-0">{{ $restaurant->address }}</p>
        </div>
        <div>
            <span class="badge {{ $restaurant->is_active ? 'badge-success' : 'badge-danger' }}">
                {{ $restaurant->is_active ? 'Active' : 'Inactive' }}
            </span>
            <span class="badge badge-secondary">
                @if($restaurant->subscription_status === 'active' && $restaurant->subscription_expires_at?->isFuture())
                    Subscribed ({{ ucfirst($restaurant->subscription_plan) }})
                @elseif($restaurant->subscription_status === 'trial' && $restaurant->trial_ends_at?->isFuture())
                    On Trial
                @else
                    No Plan
                @endif
            </span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3 col-6">
        <div class="small-box bg-info">
            <div class="inner"><h3>{{ $totalCategories }}</h3><p>Categories</p></div>
            <div class="icon"><i class="fas fa-list"></i></div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="small-box bg-success">
            <div class="inner"><h3>{{ $totalItems }}</h3><p>Menu Items</p></div>
            <div class="icon"><i class="fas fa-utensils"></i></div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner"><h3>{{ $unavailableItems }}</h3><p>Unavailable Items</p></div>
            <div class="icon"><i class="fas fa-ban"></i></div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner"><h3>{{ $totalViewsAllTime }}</h3><p>Total Views (All Time)</p></div>
            <div class="icon"><i class="fas fa-eye"></i></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h5 class="mb-0">Views — Last 7 Days ({{ $viewsThisWeek }} total, {{ $viewsToday }} today)</h5></div>
            <div class="card-body">
                <canvas id="viewsChart" style="min-height:250px;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><h5 class="mb-0">Top Item</h5></div>
            <div class="card-body text-center">
                @if($topItem)
                    @if($topItem->photo)
                        <img src="{{ asset('storage/' . $topItem->photo) }}" width="90" class="rounded mb-2">
                    @endif
                    <h6>{{ $topItem->name }}</h6>
                    <p class="text-muted mb-0">{{ $topItem->view_count }} total views</p>
                @else
                    <p class="text-muted">No views yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
<script>
    const ctx = document.getElementById('viewsChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Views',
                    data: @json($chartData),
                    borderColor: '#17a2b8',
                    backgroundColor: 'rgba(23,162,184,0.1)',
                    fill: true,
                    tension: 0.3,
                }]
            },
            options: {
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
                plugins: { legend: { display: false } }
            }
        });
    }
</script>
@endpush