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

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Products Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light" style="position: sticky; top: 0; z-index: 1;">
                        <tr>
                            <th class="border-0 ps-4" style="width: 5%;">ID</th>
                            <th class="border-0" style="width: 25%;">Product</th>
                            <th class="border-0" style="width: 15%;">Category</th>
                            <th class="border-0" style="width: 10%;">Price</th>
                            <th class="border-0" style="width: 10%;">Stock</th>
                            <th class="border-0 text-center" style="width: 10%;">Status</th>
                            <th class="border-0 text-end pe-4" style="width: 15%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td class="ps-4 pt-3">{{ $product->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($product->image && file_exists(public_path('uploads/products/' . $product->image)))
                                    <img src="{{ asset('uploads/products/'.$product->image) }}" 
                                         class="rounded border me-3" 
                                         width="50" 
                                         height="50" 
                                         style="object-fit: cover;">
                                    @else
                                    <div class="bg-light rounded border d-flex align-items-center justify-content-center me-3" 
                                         style="width: 50px; height: 50px;">
                                        <i class="bi bi-box text-muted"></i>
                                    </div>
                                    @endif
                                    <div>
                                        <div class="fw-medium">{{ $product->name }}</div>
                                        @if($product->description)
                                        <small class="text-muted">{{ Str::limit($product->description, 30) }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                    {{ $product->category->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-medium">${{ number_format($product->price, 2) }}</span>
                            </td>
                            <td>
                                @if($product->stock > 10)
                                <span class="badge bg-success">{{ $product->stock }} in stock</span>
                                @elseif($product->stock > 0)
                                <span class="badge bg-warning">{{ $product->stock }} left</span>
                                @else
                                <span class="badge bg-danger">Out of stock</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $product->status == 'active' ? 'bg-success' : 'bg-secondary' }} py-1 px-3">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editProductModal"
                                            onclick="editProduct({{ json_encode($product) }})">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteProductModal"
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
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
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
                            <input type="text" name="name" class="form-control" placeholder="Enter product name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Category *</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Price *</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="price" class="form-control" placeholder="0.00" step="0.01" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Stock Quantity *</label>
                            <input type="number" name="stock" class="form-control" placeholder="0" min="0" required>
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
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
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
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Price *</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="price" id="editPrice" class="form-control" step="0.01" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Stock Quantity *</label>
                            <input type="number" name="stock" id="editStock" class="form-control" min="0" required>
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
<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
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
                        <p class="text-muted">This product will be permanently deleted. This action cannot be undone.</p>
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
        const imageUrl = '{{ asset("uploads/products/") }}/' + product.image;
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
    form.action = '{{ route("admin.products.delete", ":id") }}'.replace(':id', id);
}

function confirmDeleteProduct() {
    const form = document.getElementById('deleteProductForm');
     form.submit();
}

// Clear form when add modal is closed
document.getElementById('addProductModal').addEventListener('hidden.bs.modal', function () {
    this.querySelector('form').reset();
});
</script>

@endsection