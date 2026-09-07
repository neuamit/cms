@extends('layouts.admin')
@section('title', 'Table Requests')
@section('content')

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>@endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Recent Requests</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Table</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $req)
                        @php $item = $items->get((string) $req->item_id); @endphp
                        <tr class="{{ $req->status === 'pending' ? 'table-warning' : '' }}">
                            <td>{{ $req->created_at?->diffForHumans() }}</td>
                            <td>{{ $req->table_number ? 'Table ' . $req->table_number : '—' }}</td>
                            <td>{{ $item->name ?? 'Unknown item' }}</td>
                            <td>{{ $req->quantity ?? 1 }}</td>
                            <td>
                                @if($req->status === 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @else
                                    <span class="badge badge-success">Handled</span>
                                @endif
                            </td>
                            <td>
                                @if($req->status === 'pending')
                                    <form action="{{ route('admin.table-requests.acknowledge', $req->_id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm btn-success">Mark Handled</button>
                                    </form>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No requests yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection