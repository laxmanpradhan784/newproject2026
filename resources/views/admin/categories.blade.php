@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')

    <div class="container-fluid py-4">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-primary mb-1">Category Management</h3>
                <p class="text-muted mb-0">Manage your product categories</p>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="bi bi-plus-circle me-1"></i> Add New Category
            </button>
        </div>

        <!-- Categories Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light" style="position: sticky; top: 0; z-index: 1;">
                            <tr class="bg-light bg-gradient border-bottom border-2">
                                <th class="ps-4 py-3 align-middle" style="width: 20px;">
                                    <span class="bg-primary bg-opacity-10 p-1 rounded-2">
                                        <i class="bi text-primary fs-6">No</i>
                                    </span>
                                </th>
                                <th class="py-3 align-middle fw-semibold text-dark" style="width: 10%;">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="bg-primary bg-opacity-10 p-1 rounded-2">
                                            <i class="bi bi-image text-primary fs-6"></i>
                                        </span>
                                        <span>Image</span>
                                    </div>
                                </th>
                                <th class="py-3 align-middle fw-semibold text-dark" style="width: 20%;">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="bg-primary bg-opacity-10 p-1 rounded-2">
                                            <i class="bi bi-card-heading text-primary fs-6"></i>
                                        </span>
                                        <span>Name</span>
                                    </div>
                                </th>
                                <th class="py-3 align-middle fw-semibold text-dark" style="width: 20%;">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="bg-primary bg-opacity-10 p-1 rounded-2">
                                            <i class="bi bi-link-45deg text-primary fs-6"></i>
                                        </span>
                                        <span>Slug</span>
                                    </div>
                                </th>
                                <th class="py-3 align-middle fw-semibold text-dark text-center" style="width: 10%;">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <span class="bg-primary bg-opacity-10 p-1 rounded-2">
                                            <i class="bi bi-toggle-on text-primary fs-6"></i>
                                        </span>
                                        <span>Status</span>
                                    </div>
                                </th>
                                <th class="py-3 align-middle fw-semibold text-dark" style="width: 15%;">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="bg-primary bg-opacity-10 p-1 rounded-2">
                                            <i class="bi bi-calendar-date text-primary fs-6"></i>
                                        </span>
                                        <span>Created</span>
                                    </div>
                                </th>
                                <th class="pe-4 py-3 align-middle fw-semibold text-dark text-end" style="width: 20%;">
                                    <div class="d-flex align-items-center justify-content-end gap-2">
                                        <span class="bg-primary bg-opacity-10 p-1 rounded-2">
                                            <i class="bi bi-sliders text-primary fs-6"></i>
                                        </span>
                                        <span>Actions</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td class="ps-4 py-3 align-middle">
                                        <div class="d-flex align-items-center gap-2">
                                            <span
                                                class="badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill px-3 py-1">
                                                {{ $loop->iteration }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <div style="width: 50px; height: 40px;">
                                            @if ($category->image && file_exists(public_path('uploads/categories/' . $category->image)))
                                                <img src="{{ asset('uploads/categories/' . $category->image) }}"
                                                    class="img-thumbnail rounded w-100 h-100 object-fit-cover p-0 border"
                                                    alt="{{ $category->name }}">
                                            @else
                                                <div
                                                    class="bg-light border rounded d-flex align-items-center justify-content-center w-100 h-100">
                                                    <i class="bi bi-image text-muted fs-5"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-medium">{{ $category->name }}</div>
                                    </td>
                                    <td>
                                        <code class="text-muted">{{ $category->slug }}</code>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('category.update-status', $category->id) }}" method="POST"
                                            class="d-inline-block">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status"
                                                value="{{ $category->status == 'active' ? 'inactive' : 'active' }}">

                                            @if ($category->status == 'active')
                                                <button type="submit"
                                                    class="btn btn-success btn-sm d-flex align-items-center gap-2 px-3">
                                                    <i class="bi bi-toggle-on fs-5"></i>
                                                    <span>Active</span>
                                                </button>
                                            @else
                                                <button type="submit"
                                                    class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-2 px-3">
                                                    <i class="bi bi-toggle-off fs-5"></i>
                                                    <span>Inactive</span>
                                                </button>
                                            @endif
                                        </form>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $category->created_at->format('d M Y') }}</small>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal" data-bs-target="#editCategoryModal"
                                                onclick="editCategory({{ json_encode($category) }})">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal" data-bs-target="#deleteCategoryModal"
                                                onclick="setDeleteId({{ $category->id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="py-5">
                                            <i class="bi bi-folder text-muted" style="font-size: 48px;"></i>
                                            <p class="text-muted mt-3">No categories found. Add your first category!</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCategoryModalLabel">
                            <i class="bi bi-plus-circle me-2"></i>
                            Add New Category
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Category Name *</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter category name"
                                required>
                        </div>
                        {{-- <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Enter category description"></textarea>
                    </div> --}}
                        <div class="mb-3">
                            <label class="form-label">Category Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="text-muted">Optional. Recommended size: 400x400px</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status *</label>
                            <select name="status" class="form-select" required>
                                <option value="active" selected>Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>
                            Add Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.categories.update') }}" enctype="multipart/form-data">

                    @csrf
                    @method('PUT') <!-- Add this line for PUT method -->
                    <input type="hidden" name="id" id="editCategoryId">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCategoryModalLabel">
                            <i class="bi bi-pencil me-2"></i>
                            Edit Category
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Category Name *</label>
                            <input type="text" name="name" id="editName" class="form-control" required>
                        </div>
                        {{-- <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="editDescription" class="form-control" rows="3"></textarea>
                    </div> --}}
                        <div class="mb-3">
                            <label class="form-label">Category Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="text-muted">Leave empty to keep current image</small>
                            <div class="mt-2" id="categoryImagePreview"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status *</label>
                            <select name="status" id="editStatus" class="form-select" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>
                            Update Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Category Modal -->
    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.categories.delete', ':id') }}" id="deleteCategoryForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title text-danger" id="deleteCategoryModalLabel">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Confirm Delete
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <i class="bi bi-trash-fill text-danger" style="font-size: 64px;"></i>
                            <h5 class="mt-3">Are you sure?</h5>
                            <p class="text-muted">This category will be permanently deleted. All products under this
                                category will be affected.</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <a href="#" class="btn btn-danger" onclick="confirmDelete()">
                            <i class="bi bi-trash me-1"></i>
                            Delete Category
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function editCategory(category) {
            document.getElementById('editCategoryId').value = category.id;
            document.getElementById('editName').value = category.name;
            document.getElementById('editDescription').value = category.description || '';
            document.getElementById('editStatus').value = category.status;

            // Show image preview
            const previewDiv = document.getElementById('categoryImagePreview');
            if (category.image) {
                const imageUrl = '{{ asset('uploads/categories/') }}/' + category.image;
                previewDiv.innerHTML = `
            <div class="border rounded p-2 bg-light">
                <p class="mb-1 small text-muted">Current Image:</p>
                <img src="${imageUrl}" style="max-width: 100px; max-height: 100px;" class="rounded">
            </div>
        `;
            } else {
                previewDiv.innerHTML = `
            <div class="border rounded p-2 bg-light text-center">
                <i class="bi bi-image text-muted"></i>
                <p class="mb-0 small text-muted">No image uploaded</p>
            </div>
        `;
            }
        }

        function setDeleteId(id) {
            const form = document.getElementById('deleteCategoryForm');
            form.action = '{{ route('admin.categories.delete', ':id') }}'.replace(':id', id);
        }

        function confirmDelete() {
            const form = document.getElementById('deleteCategoryForm');
            form.submit(); // ← THIS sends POST + _method=DELETE
        }

        // Clear form when add modal is closed
        document.getElementById('addCategoryModal').addEventListener('hidden.bs.modal', function() {
            this.querySelector('form').reset();
        });
    </script>

@endsection
