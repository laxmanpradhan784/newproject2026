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

            <div class="row">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-white border-0 py-3 px-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-0 fw-bold">Return Request</h5>
                                    <p class="text-muted small mb-0">Submit your return request below</p>
                                </div>
                                <span class="badge bg-light text-dark border small">
                                    <i class="fas fa-asterisk text-danger me-1 small"></i>Required fields
                                </span>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <form action="{{ route('returns.store', $order->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <!-- Product Selection - Compact -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold small">Select Product <span
                                            class="text-danger">*</span></label>
                                    <div class="mb-2">
                                        @foreach ($order->order_items as $item)
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="order_item_id"
                                                    id="item_{{ $item->id }}" value="{{ $item->id }}"
                                                    data-max-quantity="{{ $item->quantity }}"
                                                    {{ old('order_item_id') == $item->id ? 'checked' : ($loop->first ? 'checked' : '') }}
                                                    required>
                                                <label class="form-check-label small" for="item_{{ $item->id }}">
                                                    <div class="d-flex align-items-center">
                                                        @if ($item->product->image)
                                                            <img src="{{ asset('uploads/products/' . $item->product->image) }}"
                                                                alt="{{ $item->product->name }}" class="rounded me-2"
                                                                width="40" height="40">
                                                        @else
                                                            <div class="bg-light rounded d-flex align-items-center justify-content-center me-2"
                                                                style="width: 40px; height: 40px;">
                                                                <i class="fas fa-box text-muted small"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="fw-medium">
                                                                {{ Str::limit($item->product->name, 30) }}</div>
                                                            <div class="text-muted">
                                                                Qty: {{ $item->quantity }} •
                                                                ₹{{ number_format($item->price, 2) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <input type="hidden" name="product_id" id="product_id"
                                        value="{{ $order->order_items->first()->product_id }}">
                                </div>

                                <!-- Quantity & Type - Side by side -->
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label for="quantity" class="form-label fw-bold small">Quantity <span
                                                class="text-danger">*</span></label>
                                        <input type="number"
                                            class="form-control form-control-sm @error('quantity') is-invalid @enderror"
                                            id="quantity" name="quantity" min="1"
                                            value="{{ old('quantity', 1) }}" required>
                                        <div class="form-text small" id="maxQuantityText">Max:
                                            {{ $order->order_items->first()->quantity }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small">Return Type <span
                                                class="text-danger">*</span></label>
                                        <select
                                            class="form-select form-select-sm @error('return_type') is-invalid @enderror"
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
                                    </div>
                                </div>

                                <!-- Reason -->
                                <div class="mb-4">
                                    <label for="reason" class="form-label fw-bold small">Reason <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select form-select-sm @error('reason') is-invalid @enderror"
                                        id="reason" name="reason" required>
                                        <option value="">Select reason...</option>
                                        @foreach ($returnReasons as $reason)
                                            <option value="{{ $reason->name }}"
                                                {{ old('reason') == $reason->name ? 'selected' : '' }}>
                                                {{ $reason->name }}
                                            </option>
                                        @endforeach
                                        <option value="Other" {{ old('reason') == 'Other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                </div>

                                <!-- Description - Smaller -->
                                <div class="mb-4">
                                    <label for="description" class="form-label fw-bold small">Description <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control form-control-sm @error('description') is-invalid @enderror" id="description"
                                        name="description" rows="3" placeholder="Describe the issue..." required>{{ old('description') }}</textarea>
                                    <div class="form-text small">Minimum 10 characters</div>
                                </div>

                                <!-- Image Upload - Compact -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold small">Images (Optional)</label>
                                    <p class="text-muted small mb-2">Max 3 images, 2MB each</p>
                                    <div class="d-flex gap-2">
                                        @for ($i = 1; $i <= 3; $i++)
                                            <div class="flex-fill">
                                                <div class="border rounded p-2 text-center">
                                                    <div class="image-preview mb-1" id="preview{{ $i }}"
                                                        style="height: 60px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                    <input type="file" class="d-none image-upload"
                                                        name="image{{ $i }}" id="image{{ $i }}"
                                                        accept="image/*">
                                                    <label for="image{{ $i }}"
                                                        class="btn btn-sm btn-light w-100 small">
                                                        <i class="fas fa-plus me-1 small"></i>Add
                                                    </label>
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                </div>

                                <!-- Terms - Compact -->
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input @error('terms') is-invalid @enderror"
                                            type="checkbox" id="terms" name="terms" required>
                                        <label class="form-check-label small" for="terms">
                                            I agree to the <a href="{{ route('returns.policy') }}" target="_blank"
                                                class="text-decoration-none">Return Policy</a> <span
                                                class="text-danger">*</span>
                                        </label>
                                    </div>
                                    <div class="small text-muted mt-1 ps-4">
                                        • Original condition with tags<br>
                                        • Within {{ $returnPolicy->return_window_days ?? 30 }} days<br>
                                        • Refund in 5-7 business days
                                    </div>
                                </div>

                                <!-- Submit Buttons - Compact -->
                                <div class="d-flex justify-content-between pt-3 border-top">
                                    <a href="{{ route('returns.index') }}" class="btn btn-outline-secondary btn-sm px-3">
                                        <i class="fas fa-times me-1"></i>Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary btn-sm px-4">
                                        <i class="fas fa-paper-plane me-1"></i>Submit Request
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
