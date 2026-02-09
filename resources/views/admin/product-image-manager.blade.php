@extends('admin.layouts.app')

@section('title', 'Product Images Manager')

@section('content')
    <div class="container-fluid py-3">

        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h4 mb-1 fw-bold">Product Images Manager</h1>
                        <p class="text-muted mb-0">Manage product images in a compact view</p>
                    </div>
                    <div class="d-flex gap-2">
                        <!-- Upload Button - Triggers Modal -->
                        @if ($selectedProduct && $selectedProduct->images->count() < 5)
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#uploadModal">
                                <i class="fas fa-plus me-2"></i>Upload
                            </button>
                        @endif

                        <!-- View Button - Triggers Modal -->
                        @if ($selectedProduct && $selectedProduct->images->count() > 0)
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewModal">
                                <i class="fas fa-eye me-2"></i>View All
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content - Compact Design -->
        <div class="row">
            <!-- Product Selector -->
            <div class="col-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.product.image.manager') }}">
                            <div class="row align-items-center">
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-box"></i>
                                        </span>
                                        <select name="product_id" class="form-select" onchange="this.form.submit()">
                                            <option value="">Select a product...</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}"
                                                    {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                                    {{ $product->name }} (ID: {{ $product->id }}) -
                                                    {{ $product->images_count }}/5 images
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 mt-2 mt-md-0">
                                    <button type="submit" class="btn btn-outline-primary w-100">
                                        <i class="fas fa-search me-1"></i>Go
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if ($selectedProduct)
            <!-- Product Summary Card -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $selectedProduct->name }}</h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        <span class="badge bg-light text-dark">
                                            <i class="fas fa-hashtag me-1"></i>{{ $selectedProduct->id }}
                                        </span>
                                        <span class="badge bg-light text-dark">
                                            <i class="fas fa-tag me-1"></i>
                                            {{ $selectedProduct->category->name ?? 'N/A' }}
                                        </span>
                                        <span
                                            class="badge {{ $selectedProduct->images->count() == 5 ? 'bg-danger' : 'bg-success' }}">
                                            <i class="fas fa-images me-1"></i>
                                            {{ $selectedProduct->images->count() }}/5 images
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <!-- Quick Actions -->
                                    @if ($selectedProduct->images->count() < 5)
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#uploadModal">
                                            <i class="fas fa-upload me-1"></i>Upload
                                        </button>
                                    @endif

                                    @if ($selectedProduct->images->count() > 0)
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#viewModal">
                                            <i class="fas fa-eye me-1"></i>View
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Images Grid - Compact View -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                            <h6 class="mb-0 fw-bold">
                                <i class="fas fa-images me-2 text-primary"></i>
                                Product Images ({{ $selectedProduct->images->count() }})
                            </h6>
                            <div>
                                @if ($selectedProduct->images->count() < 5)
                                    <small class="text-success me-3">
                                        <i class="fas fa-info-circle me-1"></i>
                                        {{ 5 - $selectedProduct->images->count() }} slots available
                                    </small>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($selectedProduct->images->count() > 0)
                                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 g-2">
                                    @foreach ($selectedProduct->images as $img)
                                        <div class="col">
                                            <div class="card border-0 shadow-sm h-100">
                                                <img src="{{ asset('uploads/product-images/' . $img->image) }}"
                                                    class="card-img-top" style="height: 120px; object-fit: cover;"
                                                    alt="Product Image">
                                                <div class="card-body p-2 text-center">
                                                    <small class="text-muted d-block">Image {{ $loop->iteration }}</small>

                                                    <!-- Delete Form -->
                                                    <form action="{{ route('admin.product.images.delete', $img->id) }}"
                                                        method="POST" onsubmit="return confirm('Delete this image?')"
                                                        class="mt-1">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <!-- Add More Button -->
                                    @if ($selectedProduct->images->count() < 5)
                                        <div class="col">
                                            <button type="button"
                                                class="btn btn-outline-primary h-100 w-100 d-flex flex-column align-items-center justify-content-center"
                                                style="min-height: 150px;" data-bs-toggle="modal"
                                                data-bs-target="#uploadModal">
                                                <i class="fas fa-plus fa-2x mb-2"></i>
                                                <small>Add Image</small>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <!-- Empty State -->
                                <div class="text-center py-5">
                                    <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted mb-3">No Images Yet</h5>
                                    <p class="text-muted mb-4">Start by uploading your first product image</p>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#uploadModal">
                                        <i class="fas fa-upload me-2"></i>Upload First Image
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Select a Product</h5>
                            <p class="text-muted">Choose a product from the dropdown to manage its images</p>
                        </div>
                    </div>
                </div>
            </div>

        @endif

    </div>

    <!-- Upload Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">
                        <i class="fas fa-cloud-upload-alt me-2 text-primary"></i>Upload Images
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if ($selectedProduct && $selectedProduct->images->count() < 5)
                        <form action="{{ route('admin.product.images.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $selectedProduct->id ?? '' }}">

                            <div class="mb-4">
                                <label class="form-label fw-medium">Select Images</label>
                                <input type="file" name="images[]" multiple class="form-control" accept="image/*"
                                    required>
                                <div class="form-text">
                                    You can upload up to {{ 5 - ($selectedProduct->images->count() ?? 0) }} more images.
                                    Max size: 2MB per image.
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-upload me-2"></i>Upload Now
                                </button>
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-exclamation-triangle fa-2x text-warning mb-3"></i>
                            <h6 class="mb-3">Upload Not Available</h6>
                            @if ($selectedProduct)
                                <p class="text-muted">This product has reached the maximum limit of 5 images.</p>
                                <a href="#viewModal" class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-dismiss="modal">
                                    <i class="fas fa-eye me-2"></i>View Images
                                </a>
                            @else
                                <p class="text-muted">Please select a product first to upload images.</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- View All Images Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">
                        <i class="fas fa-images me-2 text-info"></i>
                        All Images - {{ $selectedProduct->name ?? '' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if ($selectedProduct && $selectedProduct->images->count() > 0)
                        <div class="row row-cols-2 row-cols-md-3 g-3">
                            @foreach ($selectedProduct->images as $img)
                                <div class="col">
                                    <div class="card border-0 shadow-sm">
                                        <img src="{{ asset('uploads/product-images/' . $img->image) }}"
                                            class="card-img-top" style="height: 150px; object-fit: cover;"
                                            alt="Product Image">
                                        <div class="card-body p-2 text-center">
                                            <small class="text-muted d-block mb-1">Image {{ $loop->iteration }}</small>

                                            <!-- Delete Form -->
                                            <form action="{{ route('admin.product.images.delete', $img->id) }}"
                                                method="POST" onsubmit="return confirm('Delete this image?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                                    <i class="fas fa-trash-alt me-1"></i>Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Quick Upload Button -->
                        @if ($selectedProduct->images->count() < 5)
                            <div class="text-center mt-4">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#uploadModal" data-bs-dismiss="modal">
                                    <i class="fas fa-plus me-2"></i>Upload More Images
                                </button>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-image fa-3x text-muted mb-3"></i>
                            <h6 class="mb-3">No Images Found</h6>
                            <p class="text-muted">This product doesn't have any images yet.</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#uploadModal" data-bs-dismiss="modal">
                                <i class="fas fa-upload me-2"></i>Upload Images
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Compact styling */
        .card {
            border-radius: 8px;
        }

        .card-img-top {
            border-radius: 6px 6px 0 0;
        }

        .btn-outline-danger {
            border-width: 1px;
            transition: all 0.2s;
        }

        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: white;
        }

        .modal-header {
            border-bottom: 1px solid #e9ecef;
        }

        .modal-content {
            border-radius: 10px;
            border: none;
        }

        .badge {
            padding: 0.35em 0.65em;
            font-size: 0.85em;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .row-cols-2>* {
                flex: 0 0 50%;
                max-width: 50%;
            }

            .d-flex {
                flex-direction: column;
                align-items: stretch !important;
            }

            .btn-group {
                width: 100%;
                margin-top: 1rem;
            }

            .btn-group .btn {
                flex: 1;
            }
        }

        @media (max-width: 576px) {
            .row-cols-2>* {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .card-body {
                padding: 1rem !important;
            }

            .modal-dialog {
                margin: 0.5rem;
            }
        }
    </style>
@endsection
