@extends('layouts.admin')
@section('title', 'Menu Items')
@section('content')

<div class="card">
    <div class="card-header">
        <button class="btn btn-primary" data-toggle="modal" data-target="#addItemModal">
            <i class="fas fa-plus"></i> Add Item
        </button>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr><th>Photo</th><th>Name</th><th>Category</th><th>Price</th><th>Available</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr>
                    <td>
                        @if($item->photo)
                            <img src="{{ asset('storage/' . $item->photo) }}" width="50">
                        @else
                            —
                        @endif
                    </td>
                    <td>{{ $item->name }}</td>
                    <td>
                        {{ optional($categories->firstWhere('_id', $item->category_id))->name ?? '—' }}
                    </td>
                    <td>
                        Rs. {{ $item->price }}
                        @if($item->old_price)
                            <s class="text-muted">Rs. {{ $item->old_price }}</s>
                        @endif
                    </td>
                    <td>{{ $item->is_available ? 'Yes' : 'No' }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning"
                            data-toggle="modal"
                            data-target="#editItemModal{{ $item->_id }}">
                            Edit
                        </button>
                        <form action="{{ route('admin.items.destroy', $item->_id) }}" method="POST" style="display:inline"
                            onsubmit="return confirm('Delete this item?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editItemModal{{ $item->_id }}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.items.update', $item->_id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Item</h5>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select name="category_id" class="form-control" required>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->_id }}" {{ $item->category_id == $cat->_id ? 'selected' : '' }}>
                                                    {{ $cat->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ $item->name }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control">{{ $item->description }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input type="number" step="0.01" name="price" class="form-control" value="{{ $item->price }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Old Price (optional, for discount display)</label>
                                        <input type="number" step="0.01" name="old_price" class="form-control" value="{{ $item->old_price }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Tags (comma-separated)</label>
                                        <input type="text" name="tags" class="form-control" value="{{ implode(',', $item->tags ?? []) }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Photo</label>
                                        <input type="file" name="photo" class="form-control-file">
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="is_available" class="form-check-input" value="1" {{ $item->is_available ? 'checked' : '' }}>
                                        <label class="form-check-label">Available</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <tr><td colspan="6" class="text-center">No items yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addItemModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.items.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Item</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Category</label>
                        <select name="category_id" class="form-control" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->_id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input type="number" step="0.01" name="price" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Old Price (optional)</label>
                        <input type="number" step="0.01" name="old_price" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Tags (comma-separated)</label>
                        <input type="text" name="tags" class="form-control" placeholder="veg,spicy">
                    </div>
                    <div class="form-group">
                        <label>Photo</label>
                        <input type="file" name="photo" class="form-control-file">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection