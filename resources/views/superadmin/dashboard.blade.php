@extends('layouts.admin')
@section('title', 'Super Admin Dashboard')
@section('content')

<p>Logged in as: {{ auth()->user()->name }}</p>

<div class="row">
    <div class="col-md-4">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $totalUsers }}</h3>
                <p>Total Restaurant Admins</p>
            </div>
            <div class="icon"><i class="fas fa-users"></i></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $totalActiveMenus }}</h3>
                <p>Active Menus</p>
            </div>
            <div class="icon"><i class="fas fa-store"></i></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $totalRestaurants }}</h3>
                <p>Total Restaurants</p>
            </div>
            <div class="icon"><i class="fas fa-shop"></i></div>
        </div>
    </div>
</div>

@endsection