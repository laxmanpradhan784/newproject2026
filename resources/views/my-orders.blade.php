@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
    <section>
        <div class="container">
            <!-- Header Section -->
            <div class="row">
                <div class="col-12">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}"
                                    class="text-decoration-none text-muted d-flex align-items-center">
                                    <i class="fas fa-home me-2"></i> Home
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('profile') }}" class="text-decoration-none text-muted">Profile</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">My Orders</li>
                        </ol>
                    </nav>

                    <!-- Page Header -->
                    <div
                        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-4 mb-5">
                        <div>
                            <h1 class="fw-bold mb-2" style="color: #2c3e50;">My Orders</h1>
                            <p class="text-muted mb-0">Track and manage all your purchases in one place</p>
                        </div>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="{{ route('returns.index') }}"
                                class="btn btn-outline-info px-4 py-2 rounded-pill shadow-sm">
                                <i class="fas fa-exchange-alt me-2"></i> View Returns
                            </a>
                            <div class="badge bg-primary bg-opacity-10 text-primary px-4 py-3 rounded-pill">
                                <i class="fas fa-receipt me-2"></i>
                                {{ $orders->total() }} Order{{ $orders->total() > 1 ? 's' : '' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($orders->count() > 0)
                {{-- <!-- Orders Summary -->
                <div class="row mb-2">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-header bg-white border-0 py-4">
                                <div
                                    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                                    <div>
                                        <h2 class="h4 fw-bold mb-1" style="color: #2c3e50;">Order History</h2>
                                        <p class="text-muted small mb-0">All your purchases at a glance</p>
                                    </div>
                                    <div class="badge bg-light text-dark px-3 py-2 rounded-pill">
                                        <i class="fas fa-filter me-1"></i>
                                        Showing {{ $orders->firstItem() }}-{{ $orders->lastItem() }} of
                                        {{ $orders->total() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <!-- Orders Table -->
                <div class="row">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="py-4 px-4 fw-semibold text-uppercase small"
                                                    style="color: #2c3e50;">
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                            <i class="fas fa-hashtag text-primary"></i>
                                                        </div>
                                                        Order Details
                                                    </div>
                                                </th>
                                                <th class="py-4 px-4 fw-semibold text-uppercase small"
                                                    style="color: #2c3e50;">
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                            <i class="fas fa-calendar-alt text-primary"></i>
                                                        </div>
                                                        Date & Time
                                                    </div>
                                                </th>
                                                <th class="py-4 px-4 fw-semibold text-uppercase small"
                                                    style="color: #2c3e50;">
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                            <i class="fas fa-boxes text-primary"></i>
                                                        </div>
                                                        Items
                                                    </div>
                                                </th>
                                                <th class="py-4 px-4 fw-semibold text-uppercase small"
                                                    style="color: #2c3e50;">
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                            <i class="fas fa-tag text-primary"></i>
                                                        </div>
                                                        Total Amount
                                                    </div>
                                                </th>
                                                <th class="py-4 px-4 fw-semibold text-uppercase small"
                                                    style="color: #2c3e50;">
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                            <i class="fas fa-hourglass-half text-primary"></i>
                                                        </div>
                                                        Status
                                                    </div>
                                                </th>
                                                <th class="py-4 px-4 fw-semibold text-uppercase small text-end"
                                                    style="color: #2c3e50;">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                            <i class="fas fa-cogs text-primary"></i>
                                                        </div>
                                                        Actions
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr class="border-bottom">
                                                    <!-- Order Details -->
                                                    <td class="py-4 px-4">
                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                                                                <i class="fas fa-receipt text-primary fs-4"></i>
                                                            </div>
                                                            <div>
                                                                <div class="fw-bold mb-1">{{ $order->order_number }}</div>
                                                                <div class="text-muted small">
                                                                    <i class="fas fa-credit-card me-1"></i>
                                                                    {{ ucfirst($order->payment_method) }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <!-- Date & Time -->
                                                    <td class="py-4 px-4">
                                                        <div class="d-flex flex-column">
                                                            <span
                                                                class="fw-semibold">{{ $order->created_at->format('d M Y') }}</span>
                                                            <span
                                                                class="text-muted small">{{ $order->created_at->format('h:i A') }}</span>
                                                        </div>
                                                    </td>

                                                    <!-- Items Count -->
                                                    <td class="py-4 px-4">
                                                        <div class="d-flex align-items-center">
                                                            <span
                                                                class="badge bg-secondary bg-opacity-10 text-dark rounded-pill px-3 py-2">
                                                                <i class="fas fa-shopping-basket me-1"></i>
                                                                {{ $order->items->count() }} items
                                                            </span>
                                                        </div>
                                                    </td>

                                                    <!-- Total Amount -->
                                                    <td class="py-4 px-4">
                                                        <div class="fw-bold fs-5" style="color: #2c3e50;">
                                                            ₹{{ number_format($order->total, 2) }}
                                                        </div>
                                                    </td>

                                                    <!-- Status -->
                                                    <td class="py-4 px-4">
                                                        <div class="d-flex flex-column gap-2">
                                                            <span
                                                                class="badge bg-{{ $order->status_badge }} bg-opacity-25 text-dark border border-{{ $order->status_badge }} rounded-pill px-3 py-2">
                                                                <i class="fas fa-circle me-1 small"></i>
                                                                {{ ucfirst($order->status) }}
                                                            </span>
                                                            <span
                                                                class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }} bg-opacity-25 text-dark border border-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }} rounded-pill px-3 py-2">
                                                                <i
                                                                    class="fas fa-{{ $order->payment_status == 'paid' ? 'check-circle' : 'clock' }} me-1"></i>
                                                                {{ ucfirst($order->payment_status) }}
                                                            </span>
                                                        </div>
                                                    </td>

                                                    <!-- Actions -->
                                                    <td class="py-4 px-4 text-end">
                                                        <div class="d-flex justify-content-end gap-2">
                                                            <!-- View Details -->
                                                            <a href="{{ route('order-details', $order->order_number) }}"
                                                                class="btn btn-sm btn-outline-primary px-3 py-2 rounded-pill"
                                                                title="View Order Details">
                                                                <i class="fas fa-eye me-1"></i> View
                                                            </a>

                                                            <!-- Return Button -->
                                                            @if ($order->canBeReturned())
                                                                <a href="{{ route('returns.create', $order->id) }}"
                                                                    class="btn btn-sm btn-outline-warning px-3 py-2 rounded-pill"
                                                                    title="Return Items">
                                                                    <i class="fas fa-exchange-alt me-1"></i> Return
                                                                </a>
                                                            @endif

                                                            <!-- Cancel Button -->
                                                            {{-- @if ($order->status == 'pending')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-danger px-3 py-2 rounded-pill"
                                                                    title="Cancel Order"
                                                                    onclick="cancelOrder({{ $order->id }})">
                                                                    <i class="fas fa-times me-1"></i> Cancel
                                                                </button>
                                                            @endif --}}
                                                        </div>
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

                <!-- Pagination -->
                @if ($orders->hasPages())
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-center">
                                <nav aria-label="Orders pagination">
                                    <ul class="pagination">
                                        @if ($orders->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link rounded-pill me-2">
                                                    <i class="fas fa-chevron-left me-2"></i> Previous
                                                </span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link rounded-pill me-2"
                                                    href="{{ $orders->previousPageUrl() }}">
                                                    <i class="fas fa-chevron-left me-2"></i> Previous
                                                </a>
                                            </li>
                                        @endif

                                        @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                                            <li class="page-item {{ $orders->currentPage() == $page ? 'active' : '' }}">
                                                <a class="page-link rounded-circle mx-1" href="{{ $url }}">
                                                    {{ $page }}
                                                </a>
                                            </li>
                                        @endforeach

                                        @if ($orders->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link rounded-pill ms-2"
                                                    href="{{ $orders->nextPageUrl() }}">
                                                    Next <i class="fas fa-chevron-right ms-2"></i>
                                                </a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link rounded-pill ms-2">
                                                    Next <i class="fas fa-chevron-right ms-2"></i>
                                                </span>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-body text-center p-5">
                                <div class="position-relative mb-4">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-5 mb-4">
                                        <i class="fas fa-shopping-bag fa-4x text-primary"></i>
                                    </div>
                                    <div class="position-absolute top-0 end-0 translate-middle">
                                        <div class="bg-warning bg-opacity-25 rounded-circle p-3">
                                            <i class="fas fa-plus text-warning"></i>
                                        </div>
                                    </div>
                                </div>

                                <h3 class="fw-bold mb-3" style="color: #2c3e50;">No Orders Yet</h3>
                                <p class="text-muted mb-4 px-4">
                                    Looks like you haven't made any purchases yet. Discover amazing products and make your
                                    first order!
                                </p>

                                <div class="d-flex flex-column flex-sm-row justify-content-center gap-3 mt-4">
                                    <a href="{{ route('products') }}"
                                        class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-sm">
                                        <i class="fas fa-shopping-cart me-2"></i>Start Shopping
                                    </a>
                                    <a href="{{ route('home') }}"
                                        class="btn btn-outline-dark btn-lg px-5 py-3 rounded-pill">
                                        <i class="fas fa-home me-2"></i>Browse Home
                                    </a>
                                </div>

                                <div class="mt-5 pt-4 border-top">
                                    <p class="text-muted small mb-3">New to shopping? Here's what you can do:</p>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="p-3 rounded-3 border">
                                                <i class="fas fa-search text-primary mb-2 fs-4"></i>
                                                <h6 class="fw-semibold mb-2">Browse Products</h6>
                                                <p class="small text-muted mb-0">Explore our wide range of products</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="p-3 rounded-3 border">
                                                <i class="fas fa-heart text-primary mb-2 fs-4"></i>
                                                <h6 class="fw-semibold mb-2">Add to Wishlist</h6>
                                                <p class="small text-muted mb-0">Save items for later purchase</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="p-3 rounded-3 border">
                                                <i class="fas fa-shipping-fast text-primary mb-2 fs-4"></i>
                                                <h6 class="fw-semibold mb-2">Fast Delivery</h6>
                                                <p class="small text-muted mb-0">Quick shipping on all orders</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Return Eligibility Modal -->
    <div class="modal fade" id="returnEligibilityModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pb-0">
                    <div>
                        <h5 class="modal-title fw-bold" style="color: #2c3e50;">
                            <i class="fas fa-exchange-alt text-primary me-2"></i>Return Eligibility Check
                        </h5>
                        <p class="text-muted small mb-0">Check if your order qualifies for return</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-0">
                    <div id="eligibilityResult">
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;"
                                role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <h6 class="fw-semibold mb-2" style="color: #2c3e50;">Checking Eligibility</h6>
                            <p class="text-muted small">Please wait while we check if this order can be returned...</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                        data-bs-dismiss="modal">Close</button>
                    <a id="returnButton" href="#" class="btn btn-primary rounded-pill px-4 d-none shadow-sm">
                        <i class="fas fa-exchange-alt me-2"></i> Proceed to Return
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .table {
                margin-bottom: 0;
            }

            .table thead th {
                background-color: #f8f9fa;
                border-bottom: 2px solid #e9ecef;
                position: sticky;
                top: 0;
                z-index: 10;
            }

            .table tbody tr {
                transition: all 0.3s ease;
                border-bottom: 1px solid #e9ecef;
            }

            .table tbody tr:hover {
                background-color: rgba(13, 110, 253, 0.02);
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            }

            .table tbody tr:last-child {
                border-bottom: none;
            }

            .card {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .card:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08) !important;
            }

            .badge {
                font-weight: 500;
            }

            .btn-outline-primary:hover,
            .btn-outline-warning:hover,
            .btn-outline-danger:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            .page-link {
                border: none;
                margin: 0 2px;
            }

            .page-item.active .page-link {
                background-color: #0d6efd;
                border-color: #0d6efd;
            }

            .rounded-4 {
                border-radius: 1rem !important;
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                .table-responsive {
                    border-radius: 0.75rem;
                    overflow: hidden;
                }

                .table thead {
                    display: none;
                }

                .table tbody tr {
                    display: block;
                    margin-bottom: 1rem;
                    border: 1px solid #dee2e6;
                    border-radius: 0.75rem;
                    padding: 1rem;
                }

                .table tbody td {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 0.75rem;
                    border: none;
                }

                .table tbody td:before {
                    content: attr(data-label);
                    font-weight: 600;
                    color: #2c3e50;
                    margin-right: 1rem;
                }

                .table tbody td:last-child {
                    border-bottom: none;
                }

                .table tbody tr:last-child {
                    margin-bottom: 0;
                }
            }

            @media (max-width: 576px) {
                .btn {
                    padding: 0.5rem 0.75rem;
                    font-size: 0.875rem;
                }

                .badge {
                    font-size: 0.75rem;
                    padding: 0.25rem 0.5rem;
                }

                .card-body {
                    padding: 1rem !important;
                }

                .display-4 {
                    font-size: 2rem;
                }
            }

            /* Animation for status badges */
            .badge {
                transition: all 0.3s ease;
            }

            .badge:hover {
                transform: scale(1.05);
            }

            /* Loading animation */
            @keyframes pulse {
                0% {
                    opacity: 0.6;
                }

                50% {
                    opacity: 1;
                }

                100% {
                    opacity: 0.6;
                }
            }

            .spinner-border {
                animation: pulse 1.5s ease-in-out infinite;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            function showAlert(message, type = 'success') {
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed shadow-sm`;
                alertDiv.style.top = '20px';
                alertDiv.style.right = '20px';
                alertDiv.style.zIndex = '9999';
                alertDiv.style.minWidth = '300px';
                alertDiv.style.maxWidth = '400px';
                alertDiv.style.borderRadius = '0.75rem';

                const icon = type === 'success' ? 'fas fa-check-circle' :
                    type === 'error' ? 'fas fa-exclamation-circle' :
                    'fas fa-info-circle';

                alertDiv.innerHTML = `
                    <div class="d-flex align-items-center">
                        <i class="${icon} me-3 fs-4"></i>
                        <div class="flex-grow-1">${message}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;

                document.body.appendChild(alertDiv);

                setTimeout(() => {
                    if (alertDiv.parentNode) {
                        alertDiv.remove();
                    }
                }, 5000);
            }

            // Mobile responsiveness for table
            document.addEventListener('DOMContentLoaded', function() {
                if (window.innerWidth <= 768) {
                    const tableCells = document.querySelectorAll('.table tbody td');
                    const headers = ['Order Details', 'Date & Time', 'Items', 'Total Amount', 'Status', 'Actions'];

                    tableCells.forEach((cell, index) => {
                        const headerIndex = index % headers.length;
                        cell.setAttribute('data-label', headers[headerIndex]);
                    });
                }
            });

            // Your existing checkReturnEligibility function
            function checkReturnEligibility(orderId) {
                $('#returnEligibilityModal').modal('show');

                $.ajax({
                    url: '/returns/check-eligibility/' + orderId,
                    method: 'GET',
                    success: function(response) {
                        if (response.eligible) {
                            $('#eligibilityResult').html(`
                                <div class="text-center py-4">
                                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
                                        <i class="fas fa-check-circle fa-3x text-success"></i>
                                    </div>
                                    <h5 class="text-success fw-bold mb-2">Eligible for Return</h5>
                                    <p class="text-muted mb-3">This order can be returned within ${response.return_window} days of delivery.</p>
                                    <div class="alert alert-success bg-opacity-10 border-success border-opacity-25 rounded-3">
                                        <small>
                                            <i class="fas fa-info-circle me-1"></i>
                                            Items must be in original condition with all tags attached.
                                        </small>
                                    </div>
                                </div>
                            `);
                            $('#returnButton').removeClass('d-none')
                                .attr('href', '/returns/create/' + orderId);
                        } else {
                            $('#eligibilityResult').html(`
                                <div class="text-center py-4">
                                    <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
                                        <i class="fas fa-times-circle fa-3x text-danger"></i>
                                    </div>
                                    <h5 class="text-danger fw-bold mb-2">Not Eligible for Return</h5>
                                    <p class="text-muted mb-3">This order cannot be returned at this time.</p>
                                    <div class="alert alert-danger bg-opacity-10 border-danger border-opacity-25 rounded-3 text-start">
                                        <small>
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            Possible reasons:
                                            <ul class="mb-0 mt-2 ps-3">
                                                <li>Return window may have expired</li>
                                                <li>Order status doesn't allow returns</li>
                                                <li>Some items may be non-returnable</li>
                                                <li>Return already processed for this order</li>
                                            </ul>
                                        </small>
                                    </div>
                                </div>
                            `);
                            $('#returnButton').addClass('d-none');
                        }
                    },
                    error: function() {
                        $('#eligibilityResult').html(`
                            <div class="text-center py-4">
                                <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
                                    <i class="fas fa-exclamation-triangle fa-3x text-warning"></i>
                                </div>
                                <h5 class="text-warning fw-bold mb-2">Unable to Check</h5>
                                <p class="text-muted mb-3">We're having trouble checking eligibility. Please try again.</p>
                            </div>
                        `);
                        $('#returnButton').addClass('d-none');
                    }
                });
            }
        </script>
    @endpush
@endsection
