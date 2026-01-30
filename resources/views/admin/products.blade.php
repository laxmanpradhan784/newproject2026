@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')

    <div class="container-fluid py-4">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-primary mb-1">Product Management</h3>
                <p class="text-muted mb-0">Manage your products inventory</p>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="bi bi-plus-circle me-1"></i> Add New Product
            </button>
        </div>

        <!-- Products Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 700px; overflow-y: auto;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light" style="position: sticky; top: 0; z-index: 1;">
                            <tr class="bg-light bg-gradient border-bottom border-3">
                                <th class="ps-4 py-4 align-middle fw-semibold text-dark" style="width: 5%;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                            <i class="bi bi-hash text-primary fs-6"></i>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold">SR</span>
                                            <small class="text-muted">No</small>
                                        </div>
                                    </div>
                                </th>
                                <th class="py-4 align-middle fw-semibold text-dark" style="width: 25%;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                            <i class="bi bi-box-seam text-primary fs-6"></i>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold">Product</span>
                                            <small class="text-muted">Item Details</small>
                                        </div>
                                    </div>
                                </th>
                                <th class="py-4 align-middle fw-semibold text-dark" style="width: 15%;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                            <i class="bi bi-tags text-primary fs-6"></i>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold">Category</span>
                                            <small class="text-muted">Type</small>
                                        </div>
                                    </div>
                                </th>
                                <th class="py-4 align-middle fw-semibold text-dark" style="width: 10%;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                            <i class="bi bi-currency-rupee text-primary fs-6"></i>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold">Price</span>
                                            <small class="text-muted">Amount</small>
                                        </div>
                                    </div>
                                </th>
                                <th class="py-4 align-middle fw-semibold text-dark" style="width: 10%;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                            <i class="bi bi-box text-primary fs-6"></i>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold">Stock</span>
                                            <small class="text-muted">Qty</small>
                                        </div>
                                    </div>
                                </th>
                                <th class="py-4 align-middle fw-semibold text-dark text-center" style="width: 10%;">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                            <i class="bi bi-toggle-on text-primary fs-6"></i>
                                        </div>
                                        <div class="d-flex flex-column text-center">
                                            <span class="fw-semibold">Status</span>
                                            <small class="text-muted">State</small>
                                        </div>
                                    </div>
                                </th>
                                <th class="pe-4 py-4 align-middle fw-semibold text-dark text-end" style="width: 15%;">
                                    <div class="d-flex align-items-center justify-content-end gap-2">
                                        <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                            <i class="bi bi-sliders text-primary fs-6"></i>
                                        </div>
                                        <div class="d-flex flex-column text-end">
                                            <span class="fw-semibold">Actions</span>
                                            <small class="text-muted">Manage</small>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td class="ps-4 py-3 align-middle">
                                        <span
                                            class="badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill px-3 py-1">
                                            {{ $loop->iteration }}
                                        </span>
                                    </td>
                                    <td class="py-3 align-middle">
                                        <div class="d-flex align-items-center gap-3">
                                            <div style="width: 50px; height: 50px;" class="flex-shrink-0">
                                                @if ($product->image && file_exists(public_path('uploads/products/' . $product->image)))
                                                    <img src="{{ asset('uploads/products/' . $product->image) }}"
                                                        class="img-thumbnail rounded w-100 h-100 object-fit-cover p-0 border"
                                                        alt="{{ $product->name }}">
                                                @else
                                                    <div
                                                        class="bg-light border rounded d-flex align-items-center justify-content-center w-100 h-100">
                                                        <i class="bi bi-box text-muted fs-5"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="fw-semibold text-dark mb-1">{{ $product->name }}</div>
                                                @if ($product->description)
                                                    <small class="text-muted d-block">
                                                        <i class="bi bi-text-paragraph me-1"></i>
                                                        {{ Str::limit($product->description, 35) }}
                                                    </small>
                                                @endif
                                                @if ($product->sku)
                                                    <small class="text-muted d-block mt-1">
                                                        <i class="bi bi-upc-scan me-1"></i>
                                                        SKU: {{ $product->sku }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        @if ($product->category)
                                            <span
                                                class="badge bg-primary bg-opacity-10 text-primary border border-primary py-2 px-3">
                                                <i class="bi bi-tag me-1"></i>
                                                {{ $product->category->name }}
                                            </span>
                                        @else
                                            <span
                                                class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary py-2 px-3">
                                                <i class="bi bi-dash-circle me-1"></i>
                                                No Category
                                            </span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center gap-1">
                                            <i class="bi bi-currency-rupee text-success"></i>
                                            <span class="fw-bold text-dark">{{ number_format($product->price, 2) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($product->stock > 10)
                                            <span class="badge bg-success">{{ $product->stock }} in stock</span>
                                        @elseif($product->stock > 0)
                                            <span class="badge bg-warning">{{ $product->stock }} left</span>
                                        @else
                                            <span class="badge bg-danger">Out of stock</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        <form action="{{ route('product.update-status', $product->id) }}" method="POST"
                                            class="d-inline-block">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status"
                                                value="{{ $product->status == 'active' ? 'inactive' : 'active' }}">

                                            <button type="submit"
                                                class="btn btn-sm d-flex align-items-center gap-2 px-3 
                    {{ $product->status == 'active' ? 'btn-success' : 'btn-outline-secondary' }}">
                                                <i
                                                    class="bi {{ $product->status == 'active' ? 'bi-toggle-on' : 'bi-toggle-off' }} fs-5"></i>
                                                <span class="fw-medium">{{ ucfirst($product->status) }}</span>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal" data-bs-target="#editProductModal"
                                                onclick="editProduct({{ json_encode($product) }})">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal" data-bs-target="#deleteProductModal"
                                                onclick="setDeleteId({{ $product->id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="py-5">
                                            <i class="bi bi-box text-muted" style="font-size: 48px;"></i>
                                            <p class="text-muted mt-3">No products found. Add your first product!</p>
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

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">
                            <i class="bi bi-plus-circle me-2"></i>
                            Add New Product
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Product Name *</label>
                                <input type="text" name="name" class="form-control"
                                    placeholder="Enter product name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Category *</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Price *</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="price" class="form-control" placeholder="0.00"
                                        step="0.01" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Stock Quantity *</label>
                                <input type="number" name="stock" class="form-control" placeholder="0"
                                    min="0" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Enter product description"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Product Image</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                                <small class="text-muted">Optional. Recommended size: 500x500px</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status *</label>
                                <select name="status" class="form-select" required>
                                    <option value="active" selected>Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>
                            Add Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.products.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="editProductId">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel">
                            <i class="bi bi-pencil me-2"></i>
                            Edit Product
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Product Name *</label>
                                <input type="text" name="name" id="editName" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Category *</label>
                                <select name="category_id" id="editCategoryId" class="form-select" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Price *</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="price" id="editPrice" class="form-control"
                                        step="0.01" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Stock Quantity *</label>
                                <input type="number" name="stock" id="editStock" class="form-control" min="0"
                                    required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" id="editDescription" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Product Image</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                                <small class="text-muted">Leave empty to keep current image</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status *</label>
                                <select name="status" id="editStatus" class="form-select" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Current Image</label>
                                <div class="current-image-preview border rounded p-3 text-center bg-light">
                                    <img id="currentProductImage" src="" alt="Current Image"
                                        style="max-height: 150px; max-width: 100%;" class="rounded">
                                    <div class="mt-2" id="noProductImageMessage" style="display: none;">
                                        <i class="bi bi-image text-muted" style="font-size: 48px;"></i>
                                        <p class="text-muted">No image uploaded</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>
                            Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Product Modal -->
    <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.products.delete', ':id') }}" id="deleteProductForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title text-danger" id="deleteProductModalLabel">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Confirm Delete
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <i class="bi bi-trash-fill text-danger" style="font-size: 64px;"></i>
                            <h5 class="mt-3">Are you sure?</h5>
                            <p class="text-muted">This product will be permanently deleted. This action cannot be undone.
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <a href="#" class="btn btn-danger" onclick="confirmDeleteProduct()">
                            <i class="bi bi-trash me-1"></i>
                            Delete Product
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function editProduct(product) {
            document.getElementById('editProductId').value = product.id;
            document.getElementById('editName').value = product.name;
            document.getElementById('editCategoryId').value = product.category_id;
            document.getElementById('editPrice').value = product.price;
            document.getElementById('editStock').value = product.stock;
            document.getElementById('editDescription').value = product.description || '';
            document.getElementById('editStatus').value = product.status;

            // Show current image
            const imageElement = document.getElementById('currentProductImage');
            const noImageMessage = document.getElementById('noProductImageMessage');

            if (product.image) {
                const imageUrl = '{{ asset('uploads/products/') }}/' + product.image;
                imageElement.src = imageUrl;
                imageElement.style.display = 'block';
                noImageMessage.style.display = 'none';
            } else {
                imageElement.style.display = 'none';
                noImageMessage.style.display = 'block';
            }
        }

        function setDeleteId(id) {
            const form = document.getElementById('deleteProductForm');
            form.action = '{{ route('admin.products.delete', ':id') }}'.replace(':id', id);
        }

        function confirmDeleteProduct() {
            const form = document.getElementById('deleteProductForm');
            form.submit();
        }

        // Clear form when add modal is closed
        document.getElementById('addProductModal').addEventListener('hidden.bs.modal', function() {
            this.querySelector('form').reset();
        });
    </script>

@endsection
