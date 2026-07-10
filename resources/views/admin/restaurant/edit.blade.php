@extends('layouts.admin')
@section('title', 'My Restaurant')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.restaurant.update') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Restaurant Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $restaurant->name ?? '') }}" required>
            </div>
            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $restaurant->address ?? '') }}">
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $restaurant->phone ?? '') }}">
            </div>
            <div class="form-group">
                <label>WiFi Password</label>
                <input type="text" name="wifi_password" class="form-control" value="{{ old('wifi_password', $restaurant->wifi_password ?? '') }}">
            </div>
            <div class="form-group">
                <label>Logo</label>
                <input type="file" name="logo" class="form-control-file">
                @if(!empty($restaurant->logo))
                    <img src="{{ asset('storage/' . $restaurant->logo) }}" width="80" class="mt-2">
                @endif
            </div>
            <div class="form-group">
    <label>Cover Banner Photo (shown at the top of your public menu)</label>
    <input type="file" name="cover_image" class="form-control-file">
    @if(!empty($restaurant->cover_image))
        <img src="{{ asset('storage/' . $restaurant->cover_image) }}" width="200" class="mt-2 d-block">
    @endif
</div>
<div class="form-group">
    <label>Opening Hours (e.g. "Open daily from 7:00 AM")</label>
    <input type="text" name="opening_hours" class="form-control" value="{{ old('opening_hours', $restaurant->opening_hours ?? '') }}">
</div>
<div class="form-group">
    <label>Facebook URL</label>
    <input type="url" name="facebook_url" class="form-control" value="{{ old('facebook_url', $restaurant->facebook_url ?? '') }}">
</div>
<div class="form-group">
    <label>Instagram URL</label>
    <input type="url" name="instagram_url" class="form-control" value="{{ old('instagram_url', $restaurant->instagram_url ?? '') }}">
</div>
<div class="form-group">
    <label>TripAdvisor URL</label>
    <input type="url" name="tripadvisor_url" class="form-control" value="{{ old('tripadvisor_url', $restaurant->tripadvisor_url ?? '') }}">
</div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
@endsection