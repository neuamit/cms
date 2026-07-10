@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')

<p>Logged in as: {{ auth()->user()->name }}</p>
<div class="row">
    <div class="col-md-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalCategories }}</h3>
                <p>Total Categories</p>
            </div>
            <div class="icon"><i class="fas fa-list"></i></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $totalItems }}</h3>
                <p>Total Menu Items</p>
            </div>
            <div class="icon"><i class="fas fa-utensils"></i></div>
        </div>
    </div>
</div>
@if(!$restaurant)
    <div class="alert alert-warning">
        You haven't set up your restaurant profile yet.
        <a href="{{ route('admin.restaurant.edit') }}">Set it up now</a>.
    </div>
@else
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">{{ $restaurant->name }}</h5>
        </div>
        <div class="card-body text-center">
            <h6>Your Menu QR Code</h6>
            @php $menuUrl = route('menu.show', $restaurant->slug); @endphp
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($menuUrl) }}" alt="QR Code">
            <p class="mt-2">
                <a href="{{ $menuUrl }}" target="_blank">{{ $menuUrl }}</a>
            </p>
            <a href="https://api.qrserver.com/v1/create-qr-code/?size=500x500&data={{ urlencode($menuUrl) }}"
               download="menu-qr.png" class="btn btn-sm btn-secondary">
                Download QR (High-Res)
            </a>
            <p class="mt-3">
                <a href="{{ route('admin.restaurant.edit') }}" class="btn btn-sm btn-outline-primary">Edit Restaurant Info</a>
            </p>
        </div>
    </div>
@endif

@endsection