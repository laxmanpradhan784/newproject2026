@extends('layouts.app')

@section('title', 'Create Return Request')

@section('content')
    <div class="container-fluid py-5">
        <div class="container">
            <!-- Page Header -->
            <div class="row mb-5">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <nav aria-label="breadcrumb" class="mb-3">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}"
                                            class="text-decoration-none text-muted"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('profile') }}"
                                            class="text-decoration-none text-muted">Account</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('returns.index') }}"
                                            class="text-decoration-none text-muted">Returns</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Create Return</li>
                                </ol>
                            </nav>
                            <h1 class="display-6 fw-bold mb-2">Create Return Request</h1>
                            <p class="text-muted mb-0">Submit a return request for order #{{ $order->order_number }}</p>
                        </div>
                        <div>
                            <a href="{{ route('returns.policy') }}" class="btn btn-primary btn-lg shadow-sm">
                                <i class="fas fa-file-contract me-2"></i> Return Policy
                            </a>
                        </div>
                    </div>

                    <!-- Order Information Cards -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-3 col-6">
                            <div class="card border-0 bg-primary bg-opacity-10 rounded-3 shadow-sm h-100">
                                <div class="card-body py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-25 rounded-circle p-3 me-3">
                                            <i class="fas fa-receipt text-primary fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="text-muted mb-1">Order Total</h6>
                                            <h3 class="mb-0 fw-bold">₹{{ number_format($order->total, 2) }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="card border-0 bg-info bg-opacity-10 rounded-3 shadow-sm h-100">
                                <div class="card-body py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-info bg-opacity-25 rounded-circle p-3 me-3">
                                            <i class="fas fa-boxes text-info fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="text-muted mb-1">Items</h6>
                                            <h3 class="mb-0 fw-bold">{{ $order->order_items->count() }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="card border-0 bg-success bg-opacity-10 rounded-3 shadow-sm h-100">
                                <div class="card-body py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success bg-opacity-25 rounded-circle p-3 me-3">
                                            <i class="fas fa-calendar-check text-success fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="text-muted mb-1">Order Date</h6>
                                            <h3 class="mb-0 fw-bold">{{ $order->created_at->format('d M') }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="card border-0 bg-warning bg-opacity-10 rounded-3 shadow-sm h-100">
                                <div class="card-body py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-warning bg-opacity-25 rounded-circle p-3 me-3">
                                            <i class="fas fa-clock text-warning fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="text-muted mb-1">Return Window</h6>
                                            <h3 class="mb-0 fw-bold">{{ $returnPolicy->return_window_days ?? 30 }} days</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary rounded-pill px-4 py-2 shadow-sm" data-bs-toggle="modal"
                            data-bs-target="#orderInfoModal">
                            <i class="fas fa-info-circle me-2"></i> View Order Info
                        </button>

                    </div>
                </div>
            </div>

            <!-- Alerts -->
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4"
                    role="alert">
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
            @endif

            <!-- Main Content -->
            <div class="row">
                <!-- Return Form -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                        <div class="card-header bg-white border-0 py-4 px-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-1 fw-bold">Return Request Form</h4>
                                    <p class="text-muted mb-0">Fill in the details below to submit your return request</p>
                                </div>
                                <div
                                    class="badge bg-info bg-opacity-10 text-info fs-6 px-3 py-2 rounded-pill border border-info">
                                    <i class="fas fa-info-circle me-1"></i> Required fields are marked with *
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <form action="{{ route('returns.store', $order->id) }}" method="POST"
                                enctype="multipart/form-data" id="returnForm">
                                @csrf

                                <!-- Product Selection -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Select Product to Return <span
                                            class="text-danger">*</span></label>
                                    <div class="mb-3">
                                        @foreach ($order->order_items as $item)
                                            <div class="form-check product-option mb-3">
                                                <input class="form-check-input" type="radio" name="order_item_id"
                                                    id="item_{{ $item->id }}" value="{{ $item->id }}"
                                                    data-product-id="{{ $item->product_id }}"
                                                    data-max-quantity="{{ $item->quantity }}"
                                                    data-price="{{ $item->price }}"
                                                    {{ old('order_item_id') == $item->id ? 'checked' : ($loop->first ? 'checked' : '') }}
                                                    required>
                                                <label class="form-check-label w-100" for="item_{{ $item->id }}">
                                                    <div class="card border">
                                                        <div class="card-body">
                                                            <div class="row align-items-center">
                                                                <div class="col-auto">
                                                                    @if ($item->product->image)
                                                                        <img src="{{ asset('uploads/products/' . $item->product->image) }}"
                                                                            alt="{{ $item->product->name }}"
                                                                            class="rounded" width="60"
                                                                            height="60">
                                                                    @else
                                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                                            style="width: 60px; height: 60px;">
                                                                            <i class="fas fa-box text-muted"></i>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="col">
                                                                    <h6 class="mb-1">{{ $item->product->name }}</h6>
                                                                    <div class="d-flex flex-wrap gap-3">
                                                                        <small class="text-muted">Quantity:
                                                                            {{ $item->quantity }}</small>
                                                                        <small class="text-muted">Price:
                                                                            ₹{{ number_format($item->price, 2) }}</small>
                                                                        <small class="text-muted">Total:
                                                                            ₹{{ number_format($item->total, 2) }}</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <input type="hidden" name="product_id" id="product_id"
                                        value="{{ $order->order_items->first()->product_id }}">
                                    @error('order_item_id')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Quantity & Type -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="quantity" class="form-label fw-bold">Return Quantity <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                            id="quantity" name="quantity" min="1"
                                            value="{{ old('quantity', 1) }}" required>
                                        <div class="form-text" id="maxQuantityText">Maximum:
                                            {{ $order->order_items->first()->quantity }} units</div>
                                        @error('quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Return Type <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select @error('return_type') is-invalid @enderror"
                                            name="return_type" required>
                                            <option value="">Select Type</option>
                                            <option value="refund" {{ old('return_type') == 'refund' ? 'selected' : '' }}>
                                                Refund</option>
                                            <option value="replacement"
                                                {{ old('return_type') == 'replacement' ? 'selected' : '' }}>Replacement
                                            </option>
                                            <option value="store_credit"
                                                {{ old('return_type') == 'store_credit' ? 'selected' : '' }}>Store Credit
                                            </option>
                                        </select>
                                        @error('return_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Reason -->
                                <div class="mb-4">
                                    <label for="reason" class="form-label fw-bold">Reason for Return <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('reason') is-invalid @enderror" id="reason"
                                        name="reason" required>
                                        <option value="">Select a reason...</option>
                                        @foreach ($returnReasons as $reason)
                                            <option value="{{ $reason->name }}"
                                                {{ old('reason') == $reason->name ? 'selected' : '' }}>
                                                {{ $reason->name }}
                                            </option>
                                        @endforeach
                                        <option value="Other" {{ old('reason') == 'Other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                    @error('reason')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="mb-4">
                                    <label for="description" class="form-label fw-bold">Detailed Description <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                        rows="4" placeholder="Please provide detailed information about why you're returning this product..."
                                        required>{{ old('description') }}</textarea>
                                    <div class="form-text">Minimum 10 characters. Please be specific about any issues.
                                    </div>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Image Upload -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Upload Images (Optional)</label>
                                    <p class="text-muted small mb-3">Upload clear photos showing the product condition (max
                                        3 images, 2MB each)</p>

                                    <div class="row g-3" id="imageUploads">
                                        @for ($i = 1; $i <= 3; $i++)
                                            <div class="col-md-4">
                                                <div class="card border">
                                                    <div class="card-body text-center p-3">
                                                        <div class="image-preview mb-2" id="preview{{ $i }}">
                                                            <i class="fas fa-image fa-2x text-muted"></i>
                                                        </div>
                                                        <input type="file" class="d-none image-upload"
                                                            name="image{{ $i }}"
                                                            id="image{{ $i }}" accept="image/*">
                                                        <label for="image{{ $i }}"
                                                            class="btn btn-sm btn-outline-secondary w-100">
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
                                            type="checkbox" id="terms" name="terms" required>
                                        <label class="form-check-label" for="terms">
                                            I agree to the <a href="{{ route('returns.policy') }}" target="_blank"
                                                class="text-decoration-none">Return Policy</a> <span
                                                class="text-danger">*</span>
                                        </label>
                                        @error('terms')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        <div class="small text-muted mt-2 ps-4">
                                            <ul class="mb-0">
                                                <li>The item must be in original condition with all tags attached</li>
                                                <li>Returns must be initiated within
                                                    {{ $returnPolicy->return_window_days ?? 30 }} days of delivery</li>
                                                <li>Refunds will be processed within 5-7 business days after approval</li>
                                                <li>Shipping fees may be deducted for non-defective items</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit -->
                                <div class="d-flex justify-content-between pt-3 border-top">
                                    <a href="{{ route('returns.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                                        <i class="fas fa-arrow-left me-2"></i>Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary btn-lg px-4">
                                        <i class="fas fa-paper-plane me-2"></i>Submit Return Request
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Return Instructions -->
    <div class="modal fade" id="instructionsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Return Instructions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-block">
                                <i class="fas fa-box fa-2x text-primary"></i>
                            </div>
                            <h6 class="mt-3">Pack Item</h6>
                            <p class="small text-muted">Place item in original packaging</p>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-block">
                                <i class="fas fa-print fa-2x text-primary"></i>
                            </div>
                            <h6 class="mt-3">Print Label</h6>
                            <p class="small text-muted">We'll email you a return label</p>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-block">
                                <i class="fas fa-shipping-fast fa-2x text-primary"></i>
                            </div>
                            <h6 class="mt-3">Ship Item</h6>
                            <p class="small text-muted">Drop off at nearest shipping center</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Understood</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="orderInfoModal" tabindex="-1" aria-labelledby="orderInfoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow rounded-4">

                <!-- Header -->
                <div class="modal-header border-0 bg-light rounded-top-4">
                    <h5 class="modal-title fw-bold" id="orderInfoModalLabel">
                        <i class="fas fa-info-circle text-primary me-2"></i>Order Information
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body px-4 py-3">
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
                            <span
                                class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }} px-3 py-2 rounded-pill">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="small text-muted">Return Eligibility</label><br>
                            @if ($order->canBeReturned())
                                <span class="badge bg-success px-3 py-2 rounded-pill">
                                    <i class="fas fa-check-circle me-1"></i> Eligible
                                </span>
                            @else
                                <span class="badge bg-danger px-3 py-2 rounded-pill">
                                    <i class="fas fa-times-circle me-1"></i> Not Eligible
                                </span>
                            @endif
                        </div>

                        @if ($returnPolicy)
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

                <!-- Footer -->
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4"
                        data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Product selection handling
            const productOptions = document.querySelectorAll('.product-option input[type="radio"]');
            const productIdInput = document.getElementById('product_id');
            const quantityInput = document.getElementById('quantity');
            const maxQuantityText = document.getElementById('maxQuantityText');

            productOptions.forEach(option => {
                option.addEventListener('change', function() {
                    const productId = this.getAttribute('data-product-id');
                    const maxQuantity = this.getAttribute('data-max-quantity');

                    productIdInput.value = productId;
                    quantityInput.max = maxQuantity;
                    quantityInput.value = 1;
                    maxQuantityText.textContent = `Maximum: ${maxQuantity} units`;
                });
            });

            // Image preview
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
                            <img src="${e.target.result}" class="img-fluid rounded" style="max-height: 120px;">
                            <button type="button" class="btn-close position-absolute top-0 end-0 bg-white" 
                                    onclick="removeImage('${input.id}')" style="padding: 0.5rem;"></button>
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
                    alert('Please agree to the return policy terms.');
                    return false;
                }

                const quantity = parseInt(quantityInput.value);
                const max = parseInt(quantityInput.max);
                if (quantity > max) {
                    e.preventDefault();
                    alert(`Quantity cannot exceed ${max} units.`);
                    return false;
                }

                // Show instructions modal on first submit
                if (!localStorage.getItem('returnInstructionsShown')) {
                    e.preventDefault();
                    $('#instructionsModal').modal('show');
                    localStorage.setItem('returnInstructionsShown', 'true');

                    $('#instructionsModal').on('hidden.bs.modal', function() {
                        form.submit();
                    });
                }
            });
        });

        function removeImage(inputId) {
            const input = document.getElementById(inputId);
            const previewId = inputId.replace('image', 'preview');
            const preview = document.getElementById(previewId);

            input.value = '';
            preview.innerHTML = '<i class="fas fa-image fa-2x text-muted"></i>';
        }
    </script>

    <style>
        .product-option .form-check-input {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
        }

        .product-option .form-check-label {
            padding-left: 40px;
        }

        .product-option .form-check-input:checked+.form-check-label .card {
            border-color: #0d6efd;
            background-color: rgba(13, 110, 253, 0.05);
        }

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
            border-color: #adb5bd;
        }

        .card {
            border: 1px solid #e0e0e0;
            transition: all 0.2s;
        }

        .card:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 0;
        }

        .breadcrumb-item a {
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: #6c757d;
        }

        .badge {
            font-weight: 500;
        }
    </style>
@endpush
