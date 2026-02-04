@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
    <section class="my-orders py-5 bg-light">
        <div class="container">
            <!-- Breadcrumb with improved styling -->
            <div class="row mb-5">
                <div class="col-12">
                    <div class="d-flex flex-column gap-1">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-2">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('home') }}" class="text-decoration-none text-muted">
                                        <i class="fas fa-home me-1"></i>Home
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('profile') }}" class="text-decoration-none text-muted">Profile</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">My Orders</li>
                            </ol>
                        </nav>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h1 class="fw-bold mb-2">My Orders</h1>
                                <p class="text-muted mb-0">Track and manage all your purchases in one place</p>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('returns.index') }}" class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-exchange-alt me-1"></i> View Returns
                                </a>
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                                    <i class="fas fa-receipt me-1"></i>
                                    {{ $orders->total() }} Order{{ $orders->total() > 1 ? 's' : '' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($orders->count() > 0)
                <div class="row">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-header bg-white border-0 py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="h5 mb-0 fw-semibold">Order History</h2>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-muted small">
                                            Showing {{ $orders->firstItem() }}-{{ $orders->lastItem() }} of
                                            {{ $orders->total() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="bg-light bg-opacity-50 position-sticky top-0">
                                            <tr class="bg-gradient">
                                                <th
                                                    class="py-4 px-4 border-0 fw-bold text-uppercase small text-primary position-sticky top-0">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-hashtag me-2"></i>
                                                        Order No
                                                    </div>
                                                </th>
                                                <th
                                                    class="py-4 px-4 border-0 fw-bold text-uppercase small text-primary position-sticky top-0">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-calendar-alt me-2"></i>
                                                        Date
                                                    </div>
                                                </th>
                                                <th
                                                    class="py-4 px-4 border-0 fw-bold text-uppercase small text-primary position-sticky top-0">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-boxes me-2"></i>
                                                        Items
                                                    </div>
                                                </th>
                                                <th
                                                    class="py-4 px-4 border-0 fw-bold text-uppercase small text-primary position-sticky top-0">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-tag me-2"></i>
                                                        Total
                                                    </div>
                                                </th>
                                                <th
                                                    class="py-4 px-4 border-0 fw-bold text-uppercase small text-primary position-sticky top-0">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-hourglass-half me-2"></i>
                                                        Status
                                                    </div>
                                                </th>
                                                <th
                                                    class="py-4 px-4 border-0 fw-bold text-uppercase small text-primary position-sticky top-0">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-credit-card me-2"></i>
                                                        Payment
                                                    </div>
                                                </th>
                                                <th
                                                    class="py-4 px-4 border-0 fw-bold text-uppercase small text-primary position-sticky top-0 text-end">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <i class="fas fa-cogs me-2"></i>
                                                        Actions
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr class="border-bottom">
                                                    <td class="py-4 px-4">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                                                <i class="fas fa-receipt text-primary fs-6"></i>
                                                            </div>
                                                            <div>
                                                                <strong class="d-block">{{ $order->order_number }}</strong>
                                                                <small
                                                                    class="text-muted">{{ $order->payment_method }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="py-4 px-4">
                                                        <div class="d-flex flex-column">
                                                            <span
                                                                class="fw-medium">{{ $order->created_at->format('d M Y') }}</span>
                                                            <small
                                                                class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                                        </div>
                                                    </td>
                                                    <td class="py-4 px-4">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span
                                                                class="badge bg-secondary bg-opacity-10 text-dark rounded-pill px-3 py-1">
                                                                {{ $order->items->count() }} items
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td class="py-4 px-4">
                                                        <span
                                                            class="fw-bold fs-5 text-dark">₹{{ number_format($order->total, 2) }}</span>
                                                    </td>
                                                    <td class="py-4 px-4">
                                                        <span
                                                            class="badge bg-{{ $order->status_badge }} bg-opacity-25 text-dark border border-{{ $order->status_badge }} rounded-pill px-3 py-2">
                                                            <i class="fas fa-circle-small me-1"></i>
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                    </td>
                                                    <td class="py-4 px-4">
                                                        <span
                                                            class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }} bg-opacity-25 text-dark border border-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }} rounded-pill px-3 py-2">
                                                            <i
                                                                class="fas fa-{{ $order->payment_status == 'paid' ? 'check-circle' : 'clock' }} me-1"></i>
                                                            {{ ucfirst($order->payment_status) }}
                                                        </span>
                                                    </td>
                                                    <td class="py-4 px-4 text-end">
                                                        <div class="d-flex justify-content-end gap-2">
                                                            <!-- View Details Button -->
                                                            <a href="{{ route('order-details', $order->order_number) }}"
                                                                class="btn btn-sm btn-outline-primary border-2 px-3 py-2 rounded-3 fw-medium"
                                                                title="View Order Details">
                                                                <i class="fas fa-eye me-1"></i> View
                                                            </a>

                                                            <!-- Return Items Button -->
                                                            @if ($order->canBeReturned())
                                                                <a href="{{ route('returns.create', $order->id) }}"
                                                                    class="btn btn-sm btn-outline-warning border-2 px-3 py-2 rounded-3 fw-medium"
                                                                    title="Return Items">
                                                                    <i class="fas fa-exchange-alt me-1"></i> Return
                                                                </a>
                                                            @endif

                                                            <!-- Write Review Button -->
                                                            {{-- @if ($order->status == 'delivered' || $order->status == 'completed')
                                                                <a href="{{ route('reviews.create', $order->id) }}"
                                                                    class="btn btn-sm btn-outline-success border-2 px-3 py-2 rounded-3 fw-medium"
                                                                    title="Write Review">
                                                                    <i class="fas fa-star me-1"></i> Review
                                                                </a>
                                                            @endif --}}

                                                            <!-- Cancel Order Button -->
                                                            @if ($order->status == 'pending')
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-danger border-2 px-3 py-2 rounded-3 fw-medium"
                                                                    title="Cancel Order"
                                                                    onclick="cancelOrder({{ $order->id }})">
                                                                    <i class="fas fa-times me-1"></i> Cancel
                                                                </button>
                                                            @endif
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
            @else
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-body text-center p-5">
                                <div class="position-relative mb-4">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
                                        <i class="fas fa-shopping-bag fa-3x text-primary"></i>
                                    </div>
                                    <div class="position-absolute top-0 end-0 translate-middle">
                                        <div class="bg-warning bg-opacity-25 rounded-circle p-2">
                                            <i class="fas fa-plus text-warning"></i>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="fw-bold mb-3">No Orders Yet</h3>
                                <p class="text-muted mb-4 px-3">Looks like you haven't made any purchases yet. Discover
                                    amazing products and make your first order!</p>
                                <div class="d-flex justify-content-center gap-3">
                                    <a href="{{ route('products') }}"
                                        class="btn btn-primary btn-lg px-4 py-3 rounded-3 fw-semibold">
                                        <i class="fas fa-shopping-cart me-2"></i>Start Shopping
                                    </a>
                                    <a href="{{ route('home') }}"
                                        class="btn btn-outline-dark btn-lg px-4 py-3 rounded-3 fw-semibold">
                                        <i class="fas fa-home me-2"></i>Browse Home
                                    </a>
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
                    <h5 class="modal-title fw-bold">Return Eligibility Check</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-0">
                    <div id="eligibilityResult">
                        <div class="text-center py-4">
                            <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;"
                                role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <h6 class="fw-semibold mb-2">Checking Eligibility</h6>
                            <p class="text-muted small">Please wait while we check if this order can be returned...</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary rounded-3 px-4"
                        data-bs-dismiss="modal">Close</button>
                    <a id="returnButton" href="#" class="btn btn-primary rounded-3 px-4 d-none">
                        <i class="fas fa-exchange-alt me-2"></i> Proceed to Return
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .my-orders {
                min-height: calc(100vh - 200px);
            }

            .table tbody tr {
                transition: all 0.2s ease;
            }

            .table tbody tr:hover {
                background-color: rgba(var(--bs-primary-rgb), 0.02);
                transform: translateY(-1px);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            }

            .table thead th {
                letter-spacing: 0.5px;
                border-bottom: 2px solid #dee2e6;
            }

            .badge {
                font-weight: 500;
            }

            .card {
                transition: transform 0.3s ease;
            }

            .card:hover {
                transform: translateY(-2px);
            }

            .rounded-4 {
                border-radius: 1rem !important;
            }

            .btn-outline-dark:hover {
                background-color: #212529;
                color: white;
            }

            .dropdown-menu {
                min-width: 220px;
            }

            .dropdown-item {
                border-radius: 0.5rem;
                margin: 0 0.5rem;
                transition: all 0.2s;
            }

            .dropdown-item:hover {
                background-color: rgba(var(--bs-primary-rgb), 0.1);
            }

            .modal-content {
                border: none;
            }

            .modal-header {
                padding: 1.5rem 1.5rem 0.5rem;
            }

            .modal-body {
                padding: 0 1.5rem;
            }

            .modal-footer {
                padding: 1rem 1.5rem 1.5rem;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            function checkReturnEligibility(orderId) {
                $('#returnEligibilityModal').modal('show');

                $.ajax({
                    url: '/returns/check-eligibility/' + orderId,
                    method: 'GET',
                    success: function(response) {
                        if (response.eligible) {
                            $('#eligibilityResult').html(`
                                <div class="text-center py-3">
                                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                        <i class="fas fa-check-circle fa-2x text-success"></i>
                                    </div>
                                    <h5 class="text-success fw-bold mb-2">Eligible for Return</h5>
                                    <p class="text-muted mb-3">This order can be returned within ${response.return_window} days of delivery.</p>
                                    <div class="alert alert-success bg-opacity-10 border-success border-opacity-25">
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
                                <div class="text-center py-3">
                                    <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                        <i class="fas fa-times-circle fa-2x text-danger"></i>
                                    </div>
                                    <h5 class="text-danger fw-bold mb-2">Not Eligible for Return</h5>
                                    <p class="text-muted mb-3">This order cannot be returned at this time.</p>
                                    <div class="alert alert-danger bg-opacity-10 border-danger border-opacity-25 text-start">
                                        <small>
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            Possible reasons:
                                            <ul class="mb-0 mt-2">
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
                            <div class="text-center py-3">
                                <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                    <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
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
