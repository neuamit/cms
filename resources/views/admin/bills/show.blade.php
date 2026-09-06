@extends('layouts.admin')
@section('title', 'Table ' . $tableNumber . ' Bill')
@section('content')

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Table {{ $tableNumber }}</h5>
        <a href="{{ route('admin.bills.index') }}" class="btn btn-sm btn-secondary">Back</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr><th>Item</th><th>Price</th><th>Qty</th><th>Subtotal</th><th></th></tr>
            </thead>
            <tbody>
                @forelse($bill->items ?? [] as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>Rs. {{ number_format($item['price']) }}</td>
                    <td style="max-width:100px;">
                        <form method="POST" action="{{ route('admin.bills.update-quantity', [$bill->_id, $item['item_id']]) }}">
                            @csrf @method('PUT')
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                class="form-control form-control-sm" onchange="this.form.submit()">
                        </form>
                    </td>
                    <td>Rs. {{ number_format($item['price'] * $item['quantity']) }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.bills.remove-item', [$bill->_id, $item['item_id']]) }}">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Remove</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center">No items yet — add one below.</td></tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-right">Total</th>
                    <th colspan="2">Rs. {{ number_format($bill->total) }}</th>
                </tr>
            </tfoot>
        </table>

        <hr>
        <h6>Add Item Manually</h6>
        <form method="POST" action="{{ route('admin.bills.add-item', $bill->_id) }}" class="form-row align-items-end">
            @csrf
            <div class="col-md-6 mb-2">
                <select name="item_id" class="form-control" required>
                    <option value="">Select item...</option>
                    @foreach($allItems as $menuItem)
                        <option value="{{ $menuItem->_id }}">{{ $menuItem->name }} — Rs. {{ $menuItem->price }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <input type="number" name="quantity" value="1" min="1" class="form-control" placeholder="Qty">
            </div>
            <div class="col-md-3 mb-2">
                <button class="btn btn-primary btn-block">Add</button>
            </div>
        </form>

        @if(($bill->items ?? []) && count($bill->items))
        <form method="POST" action="{{ route('admin.bills.mark-paid', $bill->_id) }}" class="mt-3" onsubmit="return confirm('Mark this bill as paid and close it?')">
            @csrf
            <button class="btn btn-success btn-block">Mark as Paid</button>
        </form>
        @endif
    </div>
</div>

@endsection