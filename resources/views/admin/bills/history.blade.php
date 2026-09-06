@extends('layouts.admin')
@section('title', 'Bill History')
@section('content')

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Settled Bills</h5>
        <form method="GET" class="form-inline">
            <input type="date" name="date" value="{{ request('date') }}" class="form-control form-control-sm mr-2">
            <button class="btn btn-sm btn-primary">Filter</button>
            @if(request('date'))
                <a href="{{ route('admin.bills.history') }}" class="btn btn-sm btn-secondary ml-2">Clear</a>
            @endif
        </form>
    </div>
    <div class="card-body">
        <p class="mb-3"><strong>Total Revenue Shown:</strong> Rs. {{ number_format($totalRevenue) }} ({{ $bills->count() }} bills)</p>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date Closed</th>
                    <th>Table</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bills as $bill)
                <tr>
                    <td>{{ $bill->updated_at?->format('M d, Y H:i') }}</td>
                    <td>Table {{ $bill->table_number }}</td>
                    <td>
                        <small>
                            {{ collect($bill->items ?? [])->map(fn($i) => $i['name'] . ' x' . $i['quantity'])->join(', ') }}
                        </small>
                    </td>
                    <td>Rs. {{ number_format($bill->total) }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.bills.reopen', $bill->_id) }}" onsubmit="return confirm('Reopen this bill for editing? It will be removed from settled history until marked paid again.')">
                            @csrf
                            <button class="btn btn-sm btn-warning">Edit</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center">No settled bills yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection