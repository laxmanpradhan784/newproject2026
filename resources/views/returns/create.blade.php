@extends('layouts.app')

@section('title', 'Create Return Request')

@section('content')
    <div class="container-fluid mt-5 pt-5 py-4">
        <div class="container">
            <!-- Page Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <nav aria-label="breadcrumb" class="mb-3">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('home') }}" class="text-decoration-none text-muted">
                                            <i class="fas fa-home"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('profile') }}" class="text-decoration-none text-muted">Account</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('returns.index') }}" class="text-decoration-none text-muted">Returns</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Create Return</li>
                                </ol>
                            </nav>
                            <h1 class="display-6 fw-bold mb-2">Create Return Request</h1>
                            <p class="text-muted mb-0">Submit a return request for order #{{ $order->order_number }}</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('returns.policy') }}" class="btn btn-outline-primary btn-lg shadow-sm">
                                <i class="fas fa-file-contract me-2"></i> Return Policy
                            </a>
                            {{-- <button type="button" class="btn btn-primary btn-lg shadow-sm" data-bs-toggle="modal" data-bs-target="#returnFormModal">
                                <i class="fas fa-plus-circle me-2"></i> Start Return
                            </button> --}}
                        </div>
                    </div>

                    <!-- Order Information Cards -->
                    <div class="row g-3 mb-4">
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="card border-0 bg-primary bg-opacity-10 rounded-3 shadow-sm h-100">
                                <div class="card-body py-3 px-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-25 rounded-circle p-3 me-3">
                                            <i class="fas fa-receipt text-primary fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="text-muted mb-1">Order Total</h6>
                                            <h4 class="mb-0 fw-bold">₹{{ number_format($order->total, 2) }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="card border-0 bg-info bg-opacity-10 rounded-3 shadow-sm h-100">
                                <div class="card-body py-3 px-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-info bg-opacity-25 rounded-circle p-3 me-3">
                                            <i class="fas fa-boxes text-info fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="text-muted mb-1">Items</h6>
                                            <h4 class="mb-0 fw-bold">{{ $order->order_items->count() }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="card border-0 bg-success bg-opacity-10 rounded-3 shadow-sm h-100">
                                <div class="card-body py-3 px-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success bg-opacity-25 rounded-circle p-3 me-3">
                                            <i class="fas fa-calendar-check text-success fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="text-muted mb-1">Order Date</h6>
                                            <h4 class="mb-0 fw-bold">{{ $order->created_at->format('d M') }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="card border-0 bg-warning bg-opacity-10 rounded-3 shadow-sm h-100">
                                <div class="card-body py-3 px-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-warning bg-opacity-25 rounded-circle p-3 me-3">
                                            <i class="fas fa-clock text-warning fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="text-muted mb-1">Return Window</h6>
                                            <h4 class="mb-0 fw-bold">{{ $returnPolicy->return_window_days ?? 30 }} days</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items Table -->
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
                        <div class="card-header bg-white border-0 py-4 px-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-1 fw-bold">Order Items</h4>
                                    <p class="text-muted mb-0">Select items to return from your order</p>
                                </div>
                                <button class="btn btn-outline-primary rounded-pill px-4 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#orderInfoModal">
                                    <i class="fas fa-info-circle me-2"></i> View Order Info
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="border-0 ps-3">Product</th>
                                            <th class="border-0 text-center">Quantity</th>
                                            <th class="border-0 text-center">Price</th>
                                            <th class="border-0 text-center">Total</th>
                                            <th class="border-0 text-end pe-3">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->order_items as $item)
                                        <tr>
                                            <td class="ps-3">
                                                <div class="d-flex align-items-center gap-3">
                                                    @if($item->product->image)
                                                        <img src="{{ asset('uploads/products/' . $item->product->image) }}" 
                                                             alt="{{ $item->product->name }}" 
                                                             class="rounded" 
                                                             width="60" 
                                                             height="60">
                                                    @else
                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                             style="width: 60px; height: 60px;">
                                                            <i class="fas fa-box text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-1">{{ $item->product->name }}</h6>
                                                        <small class="text-muted">SKU: {{ $item->product->sku ?? 'N/A' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                                                    {{ $item->quantity }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="fw-bold">₹{{ number_format($item->price, 2) }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="fw-bold text-success">₹{{ number_format($item->total, 2) }}</span>
                                            </td>
                                            <td class="text-end pe-3">
                                                <button type="button" 
                                                        class="btn btn-primary rounded-pill px-4 py-2 return-item-btn"
                                                        data-item-id="{{ $item->id }}"
                                                        data-product-id="{{ $item->product_id }}"
                                                        data-max-quantity="{{ $item->quantity }}"
                                                        data-product-name="{{ $item->product->name }}"
                                                        data-product-price="{{ $item->price }}">
                                                    <i class="fas fa-undo me-2"></i> Return Item
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alerts -->
            @if(session('error'))
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle fa-2x me-3"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="alert-heading mb-1">Attention Required</h5>
                                    <p class="mb-0">{{ session('error') }}</p>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Return Guidelines -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-4">Return Process Guidelines</h4>
                            <div class="row g-4">
                                <div class="col-lg-3 col-md-6">
                                    <div class="text-center p-3">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                                            <i class="fas fa-clipboard-check fa-2x text-primary"></i>
                                        </div>
                                        <h5 class="fw-bold mb-2">Submit Request</h5>
                                        <p class="text-muted small mb-0">Fill out the return form with details about your issue</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="text-center p-3">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                                            <i class="fas fa-print fa-2x text-primary"></i>
                                        </div>
                                        <h5 class="fw-bold mb-2">Get Label</h5>
                                        <p class="text-muted small mb-0">We'll email you a prepaid return shipping label</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="text-center p-3">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                                            <i class="fas fa-box fa-2x text-primary"></i>
                                        </div>
                                        <h5 class="fw-bold mb-2">Pack & Ship</h5>
                                        <p class="text-muted small mb-0">Pack item securely and ship using provided label</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="text-center p-3">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-block mb-3">
                                            <i class="fas fa-undo-alt fa-2x text-primary"></i>
                                        </div>
                                        <h5 class="fw-bold mb-2">Get Refund</h5>
                                        <p class="text-muted small mb-0">Receive refund within 5-7 business days after inspection</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Return Form -->
    <div class="modal fade" id="returnFormModal" tabindex="-1" aria-labelledby="returnFormModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <!-- Modal Header -->
                <div class="modal-header bg-white border-0 rounded-top-4 p-4">
                    <div>
                        <h2 class="modal-title fw-bold mb-1" id="returnFormModalLabel">Return Request Form</h2>
                        <p class="text-muted mb-0" id="selectedItemText">Submit return request for selected item</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body p-4">
                    <form action="{{ route('returns.store', $order->id) }}" method="POST" enctype="multipart/form-data" id="returnForm">
                        @csrf
                        <input type="hidden" name="order_item_id" id="modalOrderItemId" value="">
                        <input type="hidden" name="product_id" id="modalProductId" value="">

                        <!-- Selected Product Info -->
                        <div class="card border-0 bg-light rounded-3 mb-4" id="selectedProductCard" style="display: none;">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="" alt="" id="productImage" class="rounded" width="60" height="60" style="display: none;">
                                    <div>
                                        <h6 class="fw-bold mb-1" id="productName"></h6>
                                        <div class="d-flex gap-3">
                                            <small class="text-muted">Price: <span id="productPrice"></span></small>
                                            <small class="text-muted">Max Quantity: <span id="maxQuantityDisplay"></span></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quantity & Type -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="quantity" class="form-label fw-bold">
                                    Return Quantity <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       class="form-control form-control-lg @error('quantity') is-invalid @enderror" 
                                       id="quantity" 
                                       name="quantity" 
                                       min="1" 
                                       value="{{ old('quantity', 1) }}" 
                                       required>
                                <div class="form-text" id="maxQuantityText">Maximum: <span id="maxQuantityValue">1</span> units</div>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="return_type" class="form-label fw-bold">
                                    Return Type <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-lg @error('return_type') is-invalid @enderror" 
                                        name="return_type" 
                                        id="return_type" 
                                        required>
                                    <option value="">Select Type</option>
                                    <option value="refund" {{ old('return_type') == 'refund' ? 'selected' : '' }}>Refund</option>
                                    <option value="replacement" {{ old('return_type') == 'replacement' ? 'selected' : '' }}>Replacement</option>
                                    <option value="store_credit" {{ old('return_type') == 'store_credit' ? 'selected' : '' }}>Store Credit</option>
                                </select>
                                @error('return_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Reason -->
                        <div class="mb-4">
                            <label for="reason" class="form-label fw-bold">
                                Reason for Return <span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-select-lg @error('reason') is-invalid @enderror" 
                                    id="reason" 
                                    name="reason" 
                                    required>
                                <option value="">Select a reason...</option>
                                @foreach($returnReasons as $reason)
                                    <option value="{{ $reason->name }}" {{ old('reason') == $reason->name ? 'selected' : '' }}>
                                        {{ $reason->name }}
                                    </option>
                                @endforeach
                                <option value="Other" {{ old('reason') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">
                                Detailed Description <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4" 
                                      placeholder="Please provide detailed information about why you're returning this product..." 
                                      required>{{ old('description') }}</textarea>
                            <div class="form-text">Minimum 10 characters. Please be specific about any issues.</div>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Upload Images (Optional)</label>
                            <p class="text-muted small mb-3">Upload clear photos showing the product condition (max 3 images, 2MB each)</p>
                            <div class="row g-3" id="imageUploads">
                                @for($i = 1; $i <= 3; $i++)
                                    <div class="col-md-4">
                                        <div class="card border">
                                            <div class="card-body text-center p-3">
                                                <div class="image-preview mb-2" id="preview{{ $i }}">
                                                    <i class="fas fa-image fa-2x text-muted"></i>
                                                </div>
                                                <input type="file" class="d-none image-upload" name="image{{ $i }}" id="image{{ $i }}" accept="image/*">
                                                <label for="image{{ $i }}" class="btn btn-sm btn-outline-secondary w-100">
                                                    <i class="fas fa-upload me-1"></i>Add Image
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <!-- Terms -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input @error('terms') is-invalid @enderror" 
                                       type="checkbox" 
                                       id="terms" 
                                       name="terms" 
                                       required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="{{ route('returns.policy') }}" target="_blank" class="text-decoration-none">Return Policy</a> <span class="text-danger">*</span>
                                </label>
                                @error('terms')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="small text-muted mt-2 ps-4">
                                <ul class="mb-0">
                                    <li>The item must be in original condition with all tags attached</li>
                                    <li>Returns must be initiated within {{ $returnPolicy->return_window_days ?? 30 }} days of delivery</li>
                                    <li>Refunds will be processed within 5-7 business days after approval</li>
                                    <li>Shipping fees may be deducted for non-defective items</li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer bg-light border-0 rounded-bottom-4 p-4">
                    <button type="button" class="btn btn-outline-secondary btn-lg px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="submit" form="returnForm" class="btn btn-primary btn-lg px-4">
                        <i class="fas fa-paper-plane me-2"></i>Submit Return Request
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Order Info -->
    <div class="modal fade" id="orderInfoModal" tabindex="-1" aria-labelledby="orderInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-0 bg-light rounded-top-4">
                    <h5 class="modal-title fw-bold" id="orderInfoModalLabel">
                        <i class="fas fa-info-circle text-primary me-2"></i>Order Information
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 py-3">
                    <!-- Content same as before -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="small text-muted">Order Number</label>
                            <p class="fw-bold fs-5 mb-0">#{{ $order->order_number }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small text-muted">Order Date</label>
                            <p class="mb-0">{{ $order->created_at->format('F d, Y') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small text-muted">Order Status</label><br>
                            <span class="badge bg-{{ $order->status_badge }} px-3 py-2 rounded-pill">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small text-muted">Payment Status</label><br>
                            <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }} px-3 py-2 rounded-pill">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="small text-muted">Return Eligibility</label><br>
                            @if($order->canBeReturned())
                                <span class="badge bg-success px-3 py-2 rounded-pill">
                                    <i class="fas fa-check-circle me-1"></i> Eligible
                                </span>
                            @else
                                <span class="badge bg-danger px-3 py-2 rounded-pill">
                                    <i class="fas fa-times-circle me-1"></i> Not Eligible
                                </span>
                            @endif
                        </div>
                        @if($returnPolicy)
                            <div class="col-12 mt-3 pt-3 border-top">
                                <h6 class="fw-bold mb-2">
                                    <i class="fas fa-file-contract text-info me-2"></i>Policy Summary
                                </h6>
                                <ul class="list-unstyled small text-muted mb-0">
                                    <li class="mb-1">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        {{ $returnPolicy->return_window_days }}-day return window
                                    </li>
                                    <li class="mb-1">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Free returns on defective items
                                    </li>
                                    <li>
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Original condition required
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle return item button clicks
    const returnItemButtons = document.querySelectorAll('.return-item-btn');
    const returnFormModal = document.getElementById('returnFormModal');
    const modalOrderItemId = document.getElementById('modalOrderItemId');
    const modalProductId = document.getElementById('modalProductId');
    const selectedProductCard = document.getElementById('selectedProductCard');
    const productName = document.getElementById('productName');
    const productPrice = document.getElementById('productPrice');
    const maxQuantityDisplay = document.getElementById('maxQuantityDisplay');
    const quantityInput = document.getElementById('quantity');
    const maxQuantityText = document.getElementById('maxQuantityText');
    const maxQuantityValue = document.getElementById('maxQuantityValue');
    const selectedItemText = document.getElementById('selectedItemText');

    returnItemButtons.forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.getAttribute('data-item-id');
            const productId = this.getAttribute('data-product-id');
            const maxQuantity = this.getAttribute('data-max-quantity');
            const productNameText = this.getAttribute('data-product-name');
            const productPriceValue = this.getAttribute('data-product-price');

            // Set modal values
            modalOrderItemId.value = itemId;
            modalProductId.value = productId;
            productName.textContent = productNameText;
            productPrice.textContent = '₹' + parseFloat(productPriceValue).toFixed(2);
            maxQuantityDisplay.textContent = maxQuantity;
            maxQuantityValue.textContent = maxQuantity;
            quantityInput.max = maxQuantity;
            quantityInput.value = 1;
            selectedItemText.textContent = `Returning: ${productNameText}`;

            // Show selected product card
            selectedProductCard.style.display = 'block';

            // Try to get product image
            const productImage = this.closest('tr').querySelector('img');
            const productImageElement = document.getElementById('productImage');
            if (productImage && productImage.src) {
                productImageElement.src = productImage.src;
                productImageElement.style.display = 'block';
            } else {
                productImageElement.style.display = 'none';
            }

            // Open modal
            const modal = new bootstrap.Modal(returnFormModal);
            modal.show();
        });
    });

    // Image preview functionality
    document.querySelectorAll('.image-upload').forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const previewId = this.id.replace('image', 'preview');
            const preview = document.getElementById(previewId);

            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `
                        <div class="position-relative">
                            <img src="${e.target.result}" class="img-fluid rounded" style="max-height: 120px; object-fit: cover;">
                            <button type="button" class="btn-close position-absolute top-0 end-0 bg-white rounded-circle" 
                                    onclick="removeImage('${input.id}')" style="margin: 2px; padding: 5px;"></button>
                        </div>
                    `;
                }
                reader.readAsDataURL(file);
            }
        });
    });

    // Form validation
    const form = document.getElementById('returnForm');
    form.addEventListener('submit', function(e) {
        const terms = document.getElementById('terms');
        if (!terms.checked) {
            e.preventDefault();
            showToast('Please agree to the return policy terms.', 'warning');
            terms.focus();
            return false;
        }

        const quantity = parseInt(quantityInput.value);
        const max = parseInt(quantityInput.max);
        if (quantity > max) {
            e.preventDefault();
            showToast(`Quantity cannot exceed ${max} units.`, 'warning');
            quantityInput.focus();
            return false;
        }

        if (quantity < 1) {
            e.preventDefault();
            showToast('Quantity must be at least 1 unit.', 'warning');
            quantityInput.focus();
            return false;
        }

        const description = document.getElementById('description').value.trim();
        if (description.length < 10) {
            e.preventDefault();
            showToast('Description must be at least 10 characters.', 'warning');
            document.getElementById('description').focus();
            return false;
        }

        // Check if item is selected
        if (!modalOrderItemId.value) {
            e.preventDefault();
            showToast('Please select an item to return.', 'warning');
            return false;
        }
    });

    // Quantity validation on input
    quantityInput.addEventListener('input', function() {
        const max = parseInt(this.max);
        const value = parseInt(this.value);
        
        if (value > max) {
            this.value = max;
            showToast(`Maximum quantity is ${max} units`, 'info');
        }
        
        if (value < 1) {
            this.value = 1;
        }
    });

    // Show toast notification
    function showToast(message, type = 'info') {
        // Remove existing toast
        const existingToast = document.querySelector('.custom-toast');
        if (existingToast) {
            existingToast.remove();
        }

        const toast = document.createElement('div');
        toast.className = `custom-toast alert alert-${type} alert-dismissible fade show position-fixed`;
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        toast.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(toast);

        // Auto remove after 3 seconds
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
});

// Remove image function
function removeImage(inputId) {
    const input = document.getElementById(inputId);
    const previewId = inputId.replace('image', 'preview');
    const preview = document.getElementById(previewId);

    input.value = '';
    preview.innerHTML = '<i class="fas fa-image fa-2x text-muted"></i>';
}
</script>

<style>
/* Improved spacing and alignment */
.container-fluid {
    padding-left: 1rem;
    padding-right: 1rem;
}

.card {
    border: 1px solid #e9ecef;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.1) !important;
}

.card-header {
    padding-top: 1.5rem;
    padding-bottom: 1.5rem;
}

.card-body {
    padding: 1.5rem;
}

/* Form elements */
.form-control-lg, .form-select-lg {
    padding: 0.75rem 1rem;
    font-size: 1rem;
}

.form-label {
    margin-bottom: 0.75rem;
}

/* Table styling */
.table th {
    font-weight: 600;
    color: #495057;
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
}

.table td {
    vertical-align: middle;
    padding: 1rem 0.75rem;
}

/* Modal styling */
.modal-content {
    border: none;
}

.modal-header {
    padding: 1.5rem 1.5rem 1rem;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    padding: 1rem 1.5rem;
}

/* Image preview */
.image-preview {
    height: 120px;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
    cursor: pointer;
    overflow: hidden;
}

.image-preview:hover {
    border-color: #6c757d;
    background-color: #e9ecef;
}

/* Button styling */
.btn-lg {
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
}

.btn-outline-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(13, 110, 253, 0.25);
}

/* Badge styling */
.badge {
    font-weight: 500;
    letter-spacing: 0.3px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .container-fluid {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }
    
    .card-header, .card-body {
        padding: 1rem;
    }
    
    .modal-body {
        padding: 1rem;
    }
    
    .btn-lg {
        padding: 0.625rem 1.25rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
}
</style>
@endpush