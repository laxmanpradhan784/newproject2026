@extends('layouts.app')

@section('title', 'Return Request Details')

@section('content')
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <!-- Title Section -->
                <div>
                    <h1 class="h3 fw-bold mb-0">Return #RT{{ str_pad($return->id, 6, '0', STR_PAD_LEFT) }}</h1>
                </div>

                <!-- Status and Actions -->
                <div class="d-flex align-items-center gap-3">
                    @php
                        $statusColors = [
                            'pending' => ['bg' => 'warning', 'icon' => 'fas fa-clock'],
                            'approved' => ['bg' => 'success', 'icon' => 'fas fa-check-circle'],
                            'processing' => ['bg' => 'info', 'icon' => 'fas fa-sync-alt'],
                            'picked_up' => ['bg' => 'info', 'icon' => 'fas fa-truck-pickup'],
                            'shipped' => ['bg' => 'info', 'icon' => 'fas fa-shipping-fast'],
                            'delivered' => ['bg' => 'success', 'icon' => 'fas fa-check-circle'],
                            'completed' => ['bg' => 'primary', 'icon' => 'fas fa-flag-checkered'],
                            'rejected' => ['bg' => 'danger', 'icon' => 'fas fa-times-circle'],
                            'cancelled' => ['bg' => 'secondary', 'icon' => 'fas fa-ban'],
                        ];
                        $status = $return->status;
                        $statusConfig = $statusColors[$status] ?? [
                            'bg' => 'secondary',
                            'icon' => 'fas fa-question-circle',
                        ];
                    @endphp

                    <div class="status-badge bg-{{ $statusConfig['bg'] }} px-3 py-2 rounded-3">
                        <i class="{{ $statusConfig['icon'] }} me-1"></i>
                        <span class="fw-medium">{{ ucfirst(str_replace('_', ' ', $return->status)) }}</span>
                    </div>

                    <div class="vr"></div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('order-details', $return->order->order_number) }}"
                            class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye me-1"></i>Order
                        </a>
                        <a href="{{ route('returns.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Returns
                        </a>
                    </div>
                </div>
            </div>

            <!-- Return ID Banner -->
            <div class="bg-primary rounded-4 p-2 mb-2 position-relative overflow-hidden">
                <div class="position-absolute top-0 end-0 opacity-25">
                    <i class="fas fa-undo-alt fa-10x"></i>
                </div>
                <div class="position-relative z-1">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="text-white mb-2">Return #RT{{ str_pad($return->id, 6, '0', STR_PAD_LEFT) }}</h2>
                            <p class="text-white opacity-75 mb-0">
                                <i class="far fa-calendar me-2"></i>
                                Created {{ $return->created_at->format('F d, Y') }}
                                •
                                <i class="fas fa-history me-2 ms-3"></i>
                                Last updated {{ $return->updated_at->diffForHumans() }}
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="bg-white bg-opacity-10 rounded-3 p-3 d-inline-block">
                                <div class="text-white opacity-75 small">Expected Completion</div>
                                <div class="text-white fs-4 fw-bold">3-5 Business Days</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-5 border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle fs-4 me-3"></i>
                    <div class="flex-grow-1">
                        <h6 class="mb-1">Success!</h6>
                        <p class="mb-0">{{ session('success') }}</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        <div class="row g-4">
            <!-- Left Column - Main Details -->
            <div class="col-lg-8">
                <!-- Product Information Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-4">
                        <h4 class="mb-0">
                            <i class="fas fa-box-open text-primary me-2"></i>
                            Product Information
                        </h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <tbody>
                                    <tr class="border-bottom">
                                        <td class="ps-4 py-4" style="width: 120px;">
                                            <div class="product-image bg-light rounded-3 p-2">
                                                @if ($return->product->image)
                                                    <img src="{{ asset('uploads/products/' . $return->product->image) }}"
                                                        alt="{{ $return->product->name }}" class="img-fluid rounded-2">
                                                @else
                                                    <div class="d-flex align-items-center justify-content-center h-100">
                                                        <i class="fas fa-box text-muted fa-2x"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-4">
                                            <h5 class="fw-bold mb-2">{{ $return->product->name }}</h5>
                                            <div class="row g-3">
                                                <div class="col-sm-6">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="fas fa-barcode text-muted me-2"></i>
                                                        <div>
                                                            <small class="text-muted d-block">SKU</small>
                                                            <span class="fw-medium">{{ $return->product->sku }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="fas fa-hashtag text-muted me-2"></i>
                                                        <div>
                                                            <small class="text-muted d-block">Quantity</small>
                                                            <span class="fw-medium">{{ $return->quantity }} item(s)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="fas fa-dollar-sign text-muted me-2"></i>
                                                        <div>
                                                            <small class="text-muted d-block">Amount</small>
                                                            <span
                                                                class="fw-bold text-primary">${{ number_format($return->amount, 2) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="fas fa-exchange-alt text-muted me-2"></i>
                                                        <div>
                                                            <small class="text-muted d-block">Return Type</small>
                                                            @if ($return->return_type == 'refund')
                                                                <span
                                                                    class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-3 py-2">
                                                                    <i class="fas fa-money-bill-wave me-1"></i> Refund
                                                                </span>
                                                            @elseif($return->return_type == 'replacement')
                                                                <span
                                                                    class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3 py-2">
                                                                    <i class="fas fa-sync-alt me-1"></i> Replacement
                                                                </span>
                                                            @else
                                                                <span
                                                                    class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2">
                                                                    <i class="fas fa-credit-card me-1"></i> Store Credit
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Order & Reason Details -->
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="mb-0">
                                    <i class="fas fa-receipt text-primary me-2"></i>
                                    Order Information
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="icon-circle bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                        <i class="fas fa-shopping-bag text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Order Number</small>
                                        <a href="{{ route('order-details', $return->order->order_number) }}"
                                            class="fw-bold fs-5 text-decoration-none text-dark">
                                            #{{ $return->order->order_number }}
                                        </a>
                                    </div>
                                </div>
                                <div class="bg-light rounded-3 p-3">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <small class="text-muted d-block">Order Date</small>
                                            <span
                                                class="fw-medium">{{ $return->order->created_at->format('M d, Y') }}</span>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted d-block">Order Total</small>
                                            <span
                                                class="fw-medium">${{ number_format($return->order->total_amount, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="mb-0">
                                    <i class="fas fa-exclamation-circle text-primary me-2"></i>
                                    Return Reason
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="icon-circle bg-danger bg-opacity-10 p-3 rounded-3 me-3">
                                        <i class="fas fa-exclamation-triangle text-danger fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">{{ $return->reason }}</h6>
                                        <small class="text-muted">Primary reason for return</small>
                                    </div>
                                </div>
                                <div class="bg-light rounded-3 p-3">
                                    <h6 class="small text-muted mb-2">Description:</h6>
                                    <p class="mb-0">{{ $return->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Images Section -->
                @if ($return->image1 || $return->image2 || $return->image3)
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-header bg-white border-0 py-4">
                            <h4 class="mb-0">
                                <i class="fas fa-images text-primary me-2"></i>
                                Uploaded Images
                            </h4>
                            <p class="text-muted mb-0 small">Click on images to view in full size</p>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                @for ($i = 1; $i <= 3; $i++)
                                    @php $imageField = 'image' . $i; @endphp
                                    @if ($return->$imageField)
                                        <div class="col-md-4">
                                            <a href="{{ asset('storage/' . $return->$imageField) }}"
                                                data-lightbox="return-images"
                                                class="image-card d-block border rounded-3 overflow-hidden position-relative">
                                                <img src="{{ asset('storage/' . $return->$imageField) }}"
                                                    alt="Return Image {{ $i }}" class="img-fluid"
                                                    style="height: 200px; width: 100%; object-fit: cover;">
                                                <div
                                                    class="image-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-search-plus text-white fs-3"></i>
                                                </div>
                                            </a>
                                            <div class="text-center mt-2 small text-muted">Image {{ $i }}</div>
                                        </div>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column - Status & Actions -->
            <div class="col-lg-4">
                <!-- Status Timeline -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-4">
                        <h4 class="mb-0">
                            <i class="fas fa-stream text-primary me-2"></i>
                            Status Timeline
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        @forelse($return->statusLogs as $log)
                            <div class="timeline-item {{ $loop->first ? 'active' : '' }}">
                                <div class="timeline-marker">
                                    <i class="fas fa-circle"></i>
                                </div>
                                <div class="timeline-content">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <h6 class="fw-bold mb-0">{{ ucfirst($log->to_status) }}</h6>
                                        <span class="text-muted small">{{ $log->created_at->format('h:i A') }}</span>
                                    </div>
                                    <p class="text-muted small mb-0">
                                        {{ $log->created_at->format('M d, Y') }}
                                    </p>
                                    @if ($log->notes)
                                        <div class="mt-2 p-2 bg-light rounded">
                                            <small class="text-muted">{{ $log->notes }}</small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">No status history available</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Quick Actions -->
                {{-- <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-4">
                        <h4 class="mb-0">
                            <i class="fas fa-bolt text-primary me-2"></i>
                            Quick Actions
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-3">
                            @if ($return->status == 'pending')
                                <form action="{{ route('returns.cancel', $return->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to cancel this return request?')">
                                    @csrf
                                    <button type="submit" class="btn btn-danger w-100 py-3">
                                        <i class="fas fa-times-circle me-2"></i>Cancel Return Request
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .status-badge {
            background: linear-gradient(135deg, var(--bs-{{ $statusConfig['bg'] }}) 0%,
                    rgba(var(--bs-{{ $statusConfig['bg'] }}-rgb), 0.8) 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(var(--bs-{{ $statusConfig['bg'] }}-rgb), 0.2);
        }

        .icon-circle {
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-image {
            width: 100px;
            height: 100px;
            overflow: hidden;
        }

        .table td {
            vertical-align: middle;
        }

        .badge {
            font-weight: 500;
            font-size: 0.85rem;
        }

        /* Timeline Styles */
        .timeline-item {
            position: relative;
            padding-left: 30px;
            margin-bottom: 25px;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-marker {
            position: absolute;
            left: 0;
            top: 5px;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .timeline-marker i {
            font-size: 10px;
            color: #dee2e6;
        }

        .timeline-item.active .timeline-marker i {
            color: #0d6efd;
        }

        .timeline-content {
            border-left: 2px solid #dee2e6;
            padding-left: 20px;
            padding-bottom: 10px;
        }

        .timeline-item.active .timeline-content {
            border-left-color: #0d6efd;
        }

        .timeline-item:last-child .timeline-content {
            padding-bottom: 0;
            border-left: 2px solid transparent;
        }

        /* Image Gallery Styles */
        .image-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .image-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .image-overlay {
            background: rgba(0, 0, 0, 0.3);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .image-card:hover .image-overlay {
            opacity: 1;
        }

        /* Contact Methods */
        .contact-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .contact-methods a:hover {
            color: #0d6efd !important;
        }

        /* Card Styles */
        .card {
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Button Styles */
        .btn {
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-outline-primary {
            border-width: 2px;
        }

        .btn-outline-primary:hover {
            background-color: #0d6efd;
            color: white;
        }

        /* Alert Styles */
        .alert {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        /* Breadcrumb */
        .breadcrumb {
            background: none;
            padding: 0;
            margin-bottom: 1rem;
        }

        .breadcrumb-item a {
            text-decoration: none;
            color: #6c757d;
        }

        .breadcrumb-item.active {
            color: #0d6efd;
            font-weight: 500;
        }
    </style>
@endsection

@section('scripts')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script>
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': 'Image %1 of %2',
            'fadeDuration': 300
        });

        // Smooth scroll for timeline
        document.addEventListener('DOMContentLoaded', function() {
            const timelineItems = document.querySelectorAll('.timeline-item.active');
            if (timelineItems.length > 0) {
                const lastActive = timelineItems[timelineItems.length - 1];
                lastActive.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        });
    </script>
@endsection
