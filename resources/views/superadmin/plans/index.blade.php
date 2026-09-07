@extends('layouts.admin')
@section('title', 'Pricing Plans')
@section('content')

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

<div class="row">
    @foreach($plans as $plan)
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h5 class="mb-0">{{ $plan->label }} Plan ({{ $plan->months }} month{{ $plan->months > 1 ? 's' : '' }})</h5></div>
            <div class="card-body">
                <form method="POST" action="{{ route('superadmin.plans.update', $plan->_id) }}">
                    @csrf @method('PUT')
                    <div class="form-group">
                        <label>Display Label</label>
                        <input type="text" name="label" class="form-control" value="{{ $plan->label }}" required>
                    </div>
                    <div class="form-group">
                        <label>Price (Rs.)</label>
                        <input type="number" name="amount" step="1" min="1" class="form-control" value="{{ $plan->amount }}" required>
                    </div>
                    <button class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection