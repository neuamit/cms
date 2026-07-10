@extends('layouts.admin')
@section('title', 'All Restaurants')
@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr><th>Name</th><th>Slug</th><th>Status</th><th>Action</th></tr>
            </thead>
            <tbody>
                @foreach($restaurants as $r)
                <tr>
                    <td>{{ $r->name }}</td>
                    <td>{{ $r->slug }}</td>
                    <td>{{ $r->is_active ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <form method="POST" action="{{ route('superadmin.restaurants.toggle', $r->_id) }}">
                            @csrf
                            <button class="btn btn-sm btn-warning">Toggle</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection