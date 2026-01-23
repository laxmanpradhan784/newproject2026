@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')

<div class="container-fluid mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Category Management</h3>
        <a href="#" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add New Category
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">ID</th>
                        <th width="10%">Image</th>
                        <th width="20%">Name</th>
                        <th width="20%">Slug</th>
                        <th width="10%">Status</th>
                        <th width="15%">Created At</th>
                        <th width="20%">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($categories as $cat)
                    <tr>
                        <td>{{ $cat->id }}</td>

                        <td>
                            @if($cat->image)
                                <img src="{{ asset('uploads/categories/'.$cat->image) }}" width="50" class="rounded">
                            @else
                                <span class="text-muted">No Image</span>
                            @endif
                        </td>

                        <td>{{ $cat->name }}</td>
                        <td>{{ $cat->slug }}</td>

                        <td>
                            @if($cat->status == 'active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>

                        <td>{{ $cat->created_at->format('d M Y') }}</td>

                        <td>
                            <a href="#" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <a href="#" class="btn btn-sm btn-danger"
                               onclick="return confirm('Are you sure you want to delete this category?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            No categories found
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>
</div>

@endsection
