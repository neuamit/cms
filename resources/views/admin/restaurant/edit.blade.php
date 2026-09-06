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
            <label>Number of Tables</label>
    <input type="number" name="table_count" min="0" class="form-control" value="{{ old('table_count', $restaurant->table_count ?? 0) }}">
            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $restaurant->address ?? '') }}">
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="number" name="phone" class="form-control" value="{{ old('phone', $restaurant->phone ?? '') }}">
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
    <label>Opening Hours</label>
    <div class="row">
        <div class="col-6">
            <label class="small text-muted">Opens at</label>
            <input type="time" id="openTime" class="form-control">
        </div>
        <div class="col-6">
            <label class="small text-muted">Closes at</label>
            <input type="time" id="closeTime" class="form-control">
        </div>
    </div>
    <input type="hidden" name="opening_hours" id="openingHoursField" value="{{ old('opening_hours', $restaurant->opening_hours ?? '') }}">
    <p class="small text-muted mt-1" id="openingHoursPreview">
        {{ $restaurant->opening_hours ?? 'Pick a start and end time above' }}
    </p>
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

<script>
    function formatTime12hr(timeStr) {
        if (!timeStr) return '';
        let [hour, minute] = timeStr.split(':').map(Number);
        const period = hour >= 12 ? 'PM' : 'AM';
        hour = hour % 12 || 12;
        return `${hour}:${minute.toString().padStart(2, '0')} ${period}`;
    }

    function updateOpeningHours() {
        const open = document.getElementById('openTime').value;
        const close = document.getElementById('closeTime').value;
        const field = document.getElementById('openingHoursField');
        const preview = document.getElementById('openingHoursPreview');

        if (open && close) {
            const text = `Open daily from ${formatTime12hr(open)} to ${formatTime12hr(close)}`;
            field.value = text;
            preview.textContent = text;
        }
    }

    document.getElementById('openTime').addEventListener('change', updateOpeningHours);
    document.getElementById('closeTime').addEventListener('change', updateOpeningHours);
</script>
@endsection