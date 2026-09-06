@extends('layouts.admin')
@section('title', 'Billing')
@section('content')

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

<div class="card">
    <div class="card-header"><h5 class="mb-0">Tables with Activity</h5></div>
    <div class="card-body">
        @if($openTables->count() || $openBills->count())
        <div class="row">
            @foreach($restaurant->table_count ? range(1, $restaurant->table_count) : [] as $tableNum)
                @php $hasActivity = $openTables->contains($tableNum) || $openBills->has($tableNum); @endphp
                @if($hasActivity)
                <div class="col-md-3 col-6 mb-3">
                    <a href="{{ route('admin.bills.show', $tableNum) }}" class="btn btn-block btn-outline-primary">
                        Table {{ $tableNum }}
                        @if($openBills->has($tableNum))
                            <br><small>Rs. {{ number_format($openBills->get($tableNum)->total) }}</small>
                        @endif
                    </a>
                </div>
                @endif
            @endforeach
        </div>
        @else
            <p class="text-muted">No active tables right now.</p>
        @endif
    </div>
</div>

<div class="card mt-3">
    <div class="card-body">
        <p class="mb-2">Or open a bill for any table manually:</p>
        <form method="GET" action="{{ url('/admin/bills/table') }}" onsubmit="event.preventDefault(); window.location.href='{{ url('/admin/bills/table') }}/' + document.getElementById('manualTable').value;">
            <div class="input-group" style="max-width:250px;">
                <input type="number" id="manualTable" class="form-control" placeholder="Table number" min="1" required>
                <div class="input-group-append">
                    <button class="btn btn-primary">Open</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection