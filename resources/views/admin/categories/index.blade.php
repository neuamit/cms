@extends('layouts.admin')
@section('title', 'Categories')
@section('content')

<div class="card">
    <div class="card-header">
        <button class="btn btn-primary" data-toggle="modal" data-target="#addCategoryModal">
            <i class="fas fa-plus"></i> Add Category
        </button>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr><th>#</th><th>Name</th><th>Order</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($categories as $index => $cat)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $cat->name }}</td>
                    <td>{{ $cat->order }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning"
                            data-toggle="modal"
                            data-target="#editCategoryModal{{ $cat->_id }}">
                            Edit
                        </button>
                        <form action="{{ route('admin.categories.destroy', $cat->_id) }}" method="POST" style="display:inline"
                            onsubmit="return confirm('Delete this category? Items inside it will remain but lose their category link.')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editCategoryModal{{ $cat->_id }}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.categories.update', $cat->_id) }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Category</h5>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" name="name" class="form-control" value="{{ $cat->name }}" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <tr><td colspan="4" class="text-center">No categories yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addCategoryModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Category</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="name" class="form-control" placeholder="e.g. Beverages" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection