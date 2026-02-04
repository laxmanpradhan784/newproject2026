@extends('layouts.app')

@section('title', 'Return Request Details')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-4">
                        <nav aria-label="breadcrumb" class="mb-3">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('returns.index') }}">Returns</a></li>
                                <li class="breadcrumb-item active">Return Details</li>
                            </ol>
                        </nav>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h1 class="h3 mb-1">Return Request #RT{{ str_pad($return->id, 6, '0', STR_PAD_LEFT) }}</h1>
                                <p class="text-muted mb-0">Created on {{ $return->created_at->format('F d, Y') }}</p>
                            </div>
                            <div>
                                @php
                                    $statusColors = [
                                        'pending' => 'warning',
                                        'approved' => 'success',
                                        'processing' => 'info',
                                        'picked_up' => 'info',
                                        'shipped' => 'info',
                                        'delivered' => 'success',
                                        'completed' => 'primary',
                                        'rejected' => 'danger',
                                        'cancelled' => 'secondary',
                                    ];

                                    // Default color if status is not in array
                                    $statusColor = $statusColors[$return->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $statusColor }} fs-6 px-3 py-2">
                                    {{ ucfirst(str_replace('_', ' ', $return->status)) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-lg-8">
                                <!-- Return Details -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light py-3">
                                        <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Return Details</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="small text-muted mb-1">Order Number</label>
                                                    <p class="mb-0">
                                                        <a href="{{ route('order-details', $return->order->order_number) }}"
                                                            class="text-decoration-none fw-medium">
                                                            #{{ $return->order->order_number }}
                                                        </a>
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="small text-muted mb-1">Product</label>
                                                    <div class="d-flex align-items-center">
                                                        @if ($return->product->image)
                                                            <img src="{{ asset('storage/' . $return->product->image) }}"
                                                                alt="{{ $return->product->name }}" class="rounded me-3"
                                                                width="50" height="50">
                                                        @endif
                                                        <div>
                                                            <p class="mb-0 fw-medium">{{ $return->product->name }}</p>
                                                            <small class="text-muted">SKU:
                                                                {{ $return->product->sku }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="small text-muted mb-1">Quantity</label>
                                                    <p class="mb-0 fw-medium">{{ $return->quantity }}</p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="small text-muted mb-1">Return Type</label>
                                                    <p class="mb-0">
                                                        @if ($return->return_type == 'refund')
                                                            <span class="badge bg-info bg-opacity-10 text-info">
                                                                Refund
                                                            </span>
                                                        @elseif($return->return_type == 'replacement')
                                                            <span class="badge bg-warning bg-opacity-10 text-warning">
                                                                Replacement
                                                            </span>
                                                        @else
                                                            <span class="badge bg-success bg-opacity-10 text-success">
                                                                Store Credit
                                                            </span>
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="small text-muted mb-1">Amount</label>
                                                    <p class="mb-0 fw-bold">${{ number_format($return->amount, 2) }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <label class="small text-muted mb-2">Reason</label>
                                            <p class="mb-3 fw-medium">{{ $return->reason }}</p>

                                            <label class="small text-muted mb-2">Description</label>
                                            <div class="border rounded p-3 bg-light">
                                                {{ $return->description }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Images -->
                                @if ($return->image1 || $return->image2 || $return->image3)
                                    <div class="card mb-4">
                                        <div class="card-header bg-light py-3">
                                            <h6 class="mb-0"><i class="fas fa-images me-2"></i>Uploaded Images</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                @for ($i = 1; $i <= 3; $i++)
                                                    @php $imageField = 'image' . $i; @endphp
                                                    @if ($return->$imageField)
                                                        <div class="col-md-4">
                                                            <a href="{{ asset('storage/' . $return->$imageField) }}"
                                                                data-lightbox="return-images" class="d-block">
                                                                <img src="{{ asset('storage/' . $return->$imageField) }}"
                                                                    alt="Return Image {{ $i }}"
                                                                    class="img-fluid rounded shadow-sm"
                                                                    style="height: 150px; width: 100%; object-fit: cover;">
                                                            </a>
                                                        </div>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Right Column -->
                            <div class="col-lg-4">
                                <!-- Status Timeline -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light py-3">
                                        <h6 class="mb-0"><i class="fas fa-history me-2"></i>Status Timeline</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="timeline">
                                            @forelse($return->statusLogs as $log)
                                                <div class="timeline-item {{ $loop->first ? 'active' : '' }}">
                                                    <div class="timeline-point"></div>
                                                    <div class="timeline-content">
                                                        <div class="timeline-status">
                                                            {{ ucfirst($log->to_status) }}
                                                        </div>
                                                        <div class="timeline-date small text-muted">
                                                            {{ $log->created_at->format('M d, Y h:i A') }}
                                                        </div>
                                                        @if ($log->notes)
                                                            <div class="timeline-notes small mt-1">
                                                                {{ $log->notes }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="text-center text-muted py-3">
                                                    <i class="fas fa-history fa-2x mb-2"></i>
                                                    <p class="mb-0">No status history available</p>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light py-3">
                                        <h6 class="mb-0"><i class="fas fa-cog me-2"></i>Actions</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-grid gap-2">
                                            @if ($return->status == 'pending')
                                                <form action="{{ route('returns.cancel', $return->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to cancel this return request?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger w-100">
                                                        <i class="fas fa-times-circle me-2"></i>Cancel Return
                                                    </button>
                                                </form>
                                            @endif

                                            <a href="{{ route('order-details', $return->order->order_number) }}"
                                                class="btn btn-outline-primary">
                                                <i class="fas fa-eye me-2"></i>View Order
                                            </a>

                                            <a href="{{ route('returns.index') }}" class="btn btn-outline-secondary">
                                                <i class="fas fa-arrow-left me-2"></i>Back to Returns
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Help -->
                                <div class="card">
                                    <div class="card-header bg-light py-3">
                                        <h6 class="mb-0"><i class="fas fa-question-circle me-2"></i>Need Help?</h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="small mb-3">Contact our support team for assistance:</p>
                                        <ul class="list-unstyled small">
                                            <li class="mb-2">
                                                <i class="fas fa-envelope text-primary me-2"></i>
                                                support@example.com
                                            </li>
                                            <li class="mb-2">
                                                <i class="fas fa-phone text-primary me-2"></i>
                                                (555) 123-4567
                                            </li>
                                            <li>
                                                <i class="fas fa-clock text-primary me-2"></i>
                                                Mon-Fri, 9AM-6PM EST
                                            </li>
                                        </ul>
                                        <div class="mt-3 p-2 bg-light rounded">
                                            <small class="text-muted">
                                                <strong>Reference:</strong>
                                                RT{{ str_pad($return->id, 6, '0', STR_PAD_LEFT) }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 11px;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: #e9ecef;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 25px;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-point {
            position: absolute;
            left: -30px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #adb5bd;
            border: 3px solid white;
            z-index: 1;
        }

        .timeline-item.active .timeline-point {
            background-color: #0d6efd;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
        }

        .timeline-content {
            padding-bottom: 5px;
        }

        .timeline-status {
            font-weight: 600;
            color: #212529;
        }

        .timeline-date {
            font-size: 0.85em;
        }

        .timeline-notes {
            color: #6c757d;
            background-color: #f8f9fa;
            padding: 5px 10px;
            border-radius: 4px;
            margin-top: 5px;
        }

        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            background-color: #f8f9fa;
        }

        .badge {
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .alert {
            border: none;
            border-left: 4px solid;
        }

        .alert-success {
            border-left-color: #198754;
            background-color: #f0f9f5;
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
            'albumLabel': 'Image %1 of %2'
        });
    </script>
@endsection
