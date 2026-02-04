@extends('layouts.app')

@section('title', 'My Return Requests')

@section('content')
    <section class="checkout-page mt-5 pt-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white border-0 pt-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h1 class="h3 mb-0">My Return Requests</h1>
                                <a href="{{ route('returns.policy') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-file-contract me-1"></i> Return Policy
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if ($returns->isEmpty())
                                <div class="text-center py-5">
                                    <div class="mb-4">
                                        <i class="fas fa-exchange-alt fa-4x text-muted"></i>
                                    </div>
                                    <h4 class="text-muted mb-3">No Return Requests Yet</h4>
                                    <p class="text-muted mb-4">You haven't submitted any return requests.</p>
                                    <a href="{{ route('orders') }}" class="btn btn-primary">
                                        <i class="fas fa-shopping-bag me-2"></i>View My Orders
                                    </a>
                                </div>
                            @else
                                <!-- Filter/Sort Options -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="fas fa-search text-muted"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0" id="searchReturns" placeholder="Search returns...">
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-md-end mt-2 mt-md-0">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-outline-secondary btn-sm active" data-filter="all">All</button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm" data-filter="pending">Pending</button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm" data-filter="approved">Approved</button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm" data-filter="completed">Completed</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Returns Container with Scroll -->
                                <div class="returns-container" style="max-height: 600px; overflow-y: auto; padding-right: 10px;">
                                    @foreach ($returns as $return)
                                        <div class="return-card card mb-3 border" data-status="{{ $return->status }}">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <!-- Product Info -->
                                                    <div class="col-md-3">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 me-3">
                                                                @if ($return->product->image)
                                                                    <img src="{{ asset('storage/' . $return->product->image) }}"
                                                                        alt="{{ $return->product->name }}" 
                                                                        class="rounded" width="60" height="60">
                                                                @else
                                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                                        style="width: 60px; height: 60px;">
                                                                        <i class="fas fa-box text-muted fa-lg"></i>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <div class="fw-medium mb-1">{{ Str::limit($return->product->name, 30) }}</div>
                                                                <small class="text-muted">SKU: {{ $return->product->sku }}</small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Return Details -->
                                                    <div class="col-md-5">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <small class="text-muted d-block">Return ID</small>
                                                                <strong>#RT{{ str_pad($return->id, 6, '0', STR_PAD_LEFT) }}</strong>
                                                            </div>
                                                            <div class="col-6">
                                                                <small class="text-muted d-block">Order #</small>
                                                                <a href="{{ route('order-details', $return->order->order_number) }}"
                                                                   class="text-decoration-none fw-medium">
                                                                    #{{ $return->order->order_number }}
                                                                </a>
                                                            </div>
                                                            <div class="col-6 mt-3">
                                                                <small class="text-muted d-block">Type</small>
                                                                @if ($return->return_type == 'refund')
                                                                    <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">
                                                                        Refund
                                                                    </span>
                                                                @elseif($return->return_type == 'replacement')
                                                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25">
                                                                        Replacement
                                                                    </span>
                                                                @else
                                                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                                                                        Store Credit
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <div class="col-6 mt-3">
                                                                <small class="text-muted d-block">Quantity</small>
                                                                <strong>{{ $return->quantity }}</strong>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Status & Actions -->
                                                    <div class="col-md-4">
                                                        <div class="d-flex flex-column align-items-md-end">
                                                            <div class="mb-3">
                                                                @php
                                                                    $statusColors = [
                                                                        'pending' => 'warning',
                                                                        'approved' => 'success',
                                                                        'processing' => 'info',
                                                                        'completed' => 'primary',
                                                                        'rejected' => 'danger',
                                                                        'cancelled' => 'secondary',
                                                                    ];
                                                                @endphp
                                                                <span class="badge bg-{{ $statusColors[$return->status] ?? 'secondary' }} px-3 py-2">
                                                                    {{ ucfirst($return->status) }}
                                                                </span>
                                                            </div>
                                                            
                                                            <div class="d-flex gap-2">
                                                                <small class="text-muted">
                                                                    <i class="far fa-calendar me-1"></i>
                                                                    {{ $return->created_at->format('M d, Y') }}
                                                                </small>
                                                                <div class="vr"></div>
                                                                <a href="{{ route('returns.show', $return->id) }}"
                                                                   class="btn btn-sm btn-outline-primary" title="View Details">
                                                                    <i class="fas fa-eye me-1"></i> View
                                                                </a>
                                                                @if ($return->status == 'pending')
                                                                    <form action="{{ route('returns.cancel', $return->id) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Are you sure you want to cancel this return request?')">
                                                                        @csrf
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-outline-danger"
                                                                            title="Cancel Return">
                                                                            <i class="fas fa-times"></i>
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Pagination -->
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $returns->links() }}
                                </div>
                            @endif
                        </div>

                        @if ($returnPolicy)
                            <div class="card-footer bg-light">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h6 class="mb-1">Return Policy Summary</h6>
                                        <p class="mb-0 text-muted small">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $returnPolicy->return_window_days }}-day return window
                                            &nbsp;•&nbsp;
                                            <i class="fas fa-sync-alt me-1"></i>
                                            Free returns on defective items
                                        </p>
                                    </div>
                                    <div class="col-md-4 text-md-end">
                                        <a href="{{ route('returns.policy') }}" class="btn btn-link btn-sm">
                                            View Full Policy <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('styles')
    <style>
        .returns-container::-webkit-scrollbar {
            width: 6px;
        }

        .returns-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .returns-container::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        .returns-container::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        .return-card {
            transition: all 0.3s ease;
            border-left: 4px solid #6c757d;
        }

        .return-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .return-card[data-status="pending"] {
            border-left-color: #ffc107;
        }

        .return-card[data-status="approved"] {
            border-left-color: #198754;
        }

        .return-card[data-status="processing"] {
            border-left-color: #0dcaf0;
        }

        .return-card[data-status="completed"] {
            border-left-color: #0d6efd;
        }

        .return-card[data-status="rejected"] {
            border-left-color: #dc3545;
        }

        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
        }

        .card {
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .alert {
            border: none;
            border-left: 4px solid;
        }

        .alert-success {
            border-left-color: #198754;
            background-color: #f0f9f5;
        }

        .alert-danger {
            border-left-color: #dc3545;
            background-color: #fef5f5;
        }

        .btn-group .btn.active {
            background-color: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }

        @media (max-width: 768px) {
            .return-card .row > div {
                margin-bottom: 1rem;
            }
            
            .return-card .d-flex {
                justify-content: flex-start !important;
            }
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Filter functionality
            const filterButtons = document.querySelectorAll('[data-filter]');
            const returnCards = document.querySelectorAll('.return-card');
            const searchInput = document.getElementById('searchReturns');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    const filter = this.dataset.filter;
                    
                    // Filter cards
                    returnCards.forEach(card => {
                        if (filter === 'all' || card.dataset.status === filter) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });

            // Search functionality
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase();
                    
                    returnCards.forEach(card => {
                        const text = card.textContent.toLowerCase();
                        if (text.includes(searchTerm)) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>
@endsection