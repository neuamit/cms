@extends('layouts.admin')
@section('title', 'User Management')
@section('content')

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th><th>Email</th><th>Restaurant</th><th>Verified</th><th>Joined</th><th>Status</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $user)
                @php $restaurant = $restaurants->get((string) $user->_id); @endphp
                <tr class="{{ $user->is_banned ? 'table-danger' : '' }}">
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $restaurant->name ?? '— not set up —' }}</td>
                    <td>{{ $user->email_verified_at ? 'Yes' : 'No' }}</td>
                    <td>{{ $user->created_at?->format('M d, Y') }}</td>
                    <td>
                        @if($user->is_banned)
                            <span class="badge badge-danger">Banned</span>
                        @else
                            <span class="badge badge-success">Active</span>
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="{{ route('superadmin.users.impersonate', $user->_id) }}" style="display:inline">
                            @csrf
                            <button class="btn btn-sm btn-info" onclick="return confirm('Log in as {{ $user->name }}?')">Login As</button>
                        </form>
                        <form method="POST" action="{{ route('superadmin.users.reset-password', $user->_id) }}" style="display:inline">
                            @csrf
                            <button class="btn btn-sm btn-warning" onclick="return confirm('Reset password for {{ $user->email }}?')">Reset Password</button>
                        </form>
                        <form method="POST" action="{{ route('superadmin.users.toggle-ban', $user->_id) }}" style="display:inline">
                            @csrf
                            <button class="btn btn-sm {{ $user->is_banned ? 'btn-success' : 'btn-danger' }}">
                                {{ $user->is_banned ? 'Unban' : 'Ban' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center">No restaurant admins yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection