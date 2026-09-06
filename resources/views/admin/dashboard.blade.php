@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')

<p>Logged in as: {{ auth()->user()->name }}</p>

@if(!$restaurant)
    <div class="alert alert-warning">
        You haven't set up your restaurant profile yet.
        <a href="{{ route('admin.restaurant.edit') }}">Set it up now</a>.
    </div>
@else

    {{-- Subscription status strip --}}
    <div class="alert {{ ($restaurant->subscription_status === 'active' && $restaurant->subscription_expires_at?->isFuture()) || ($restaurant->subscription_status === 'trial' && $restaurant->trial_ends_at?->isFuture()) ? 'alert-success' : 'alert-danger' }}">
        @if($restaurant->subscription_status === 'active' && $restaurant->subscription_expires_at?->isFuture())
            <strong>Subscription Active</strong> ({{ ucfirst($restaurant->subscription_plan) }}) — expires {{ $restaurant->subscription_expires_at->format('M d, Y') }}
        @elseif($restaurant->subscription_status === 'trial' && $restaurant->trial_ends_at?->isFuture())
            <strong>Free Trial Active</strong>
        @else
            <strong>No Active Plan</strong> — your menu is hidden from customers.
            <a href="{{ route('admin.subscription.show') }}" class="alert-link">Fix this now</a>
        @endif
    </div>

    {{-- Stat cards --}}
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
                <div class="inner"><h3>{{ $viewsToday }}</h3><p>Views Today</p></div>
                <div class="icon"><i class="fas fa-eye"></i></div>
            </div>
        </div>
    </div>
<div class="row">
    <div class="col-md-3 col-6">
        <div class="small-box bg-success">
            <div class="inner"><h3>Rs. {{ number_format($salesToday) }}</h3><p>Sales Today</p></div>
            <div class="icon"><i class="fas fa-coins"></i></div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="small-box bg-info">
            <div class="inner"><h3>Rs. {{ number_format($salesThisWeek) }}</h3><p>Sales This Week</p></div>
            <div class="icon"><i class="fas fa-chart-line"></i></div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <a href="{{ route('admin.bills.index') }}" style="text-decoration:none;">
            <div class="small-box bg-warning">
                <div class="inner"><h3>{{ $openBillsCount }}</h3><p>Open Bills (Tables)</p></div>
                <div class="icon"><i class="fas fa-receipt"></i></div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-6">
        <a href="{{ route('admin.table-requests.index') }}" style="text-decoration:none;">
            <div class="small-box {{ $pendingRequests > 0 ? 'bg-danger' : 'bg-secondary' }}">
                <div class="inner"><h3>{{ $pendingRequests }}</h3><p>Pending Requests</p></div>
                <div class="icon"><i class="fas fa-bell"></i></div>
            </div>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body d-flex justify-content-around text-center">
                <div>
                    <h4 class="mb-0">{{ $billsClosedToday }}</h4>
                    <small class="text-muted">Bills Closed Today</small>
                </div>
                <div>
                    <h4 class="mb-0">Rs. {{ number_format($avgBillToday) }}</h4>
                    <small class="text-muted">Average Bill Today</small>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Views — Last 7 Days ({{ $viewsThisWeek }} total)</h5></div>
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

    <div class="card">
    <div class="card-body">
        <h6>Table QR Codes</h6>
        @if($restaurant->table_count > 0)
        <div class="row">
            @for($i = 1; $i <= $restaurant->table_count; $i++)
                @php $tableUrl = route('menu.show', $restaurant->slug) . '?table=' . $i; @endphp
                <div class="col-md-3 col-6 text-center mb-3">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($tableUrl) }}">
                    <p class="mb-0"><strong>Table {{ $i }}</strong></p>
                    <p class="mb-1">
                        <a href="{{ $tableUrl }}" target="_blank" style="font-size: 0.75rem; word-break: break-all;">
                            {{ $tableUrl }}
                        </a>
                    </p>
                    <a href="https://api.qrserver.com/v1/create-qr-code/?size=500x500&data={{ urlencode($tableUrl) }}"
                       download="table-{{ $i }}-qr.png" class="btn btn-xs btn-outline-secondary">Download</a>
                </div>
            @endfor
        </div>
        @else
            <p class="text-muted">Set your number of tables in <a href="{{ route('admin.restaurant.edit') }}">restaurant settings</a> to generate table-specific QR codes.</p>
        @endif
    </div>
</div>

@endif

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