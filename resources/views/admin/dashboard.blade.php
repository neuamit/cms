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
        <div class="card-body text-center">
            <h6>Your Menu QR Code</h6>
            @php $menuUrl = route('menu.show', $restaurant->slug); @endphp
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($menuUrl) }}" alt="QR Code">
            <p class="mt-2"><a href="{{ $menuUrl }}" target="_blank">{{ $menuUrl }}</a></p>
            <a href="https://api.qrserver.com/v1/create-qr-code/?size=500x500&data={{ urlencode($menuUrl) }}"
               download="menu-qr.png" class="btn btn-sm btn-secondary">Download QR (High-Res)</a>
            <p class="mt-3"><a href="{{ route('admin.restaurant.edit') }}" class="btn btn-sm btn-outline-primary">Edit Restaurant Info</a></p>
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