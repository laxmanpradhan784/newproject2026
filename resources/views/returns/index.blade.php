@extends('layouts.app')

@section('title', 'My Return Requests')

@section('content')
    <section class="checkout-page ">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-0 pt-4 pb-3">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                <div>
                                    <h1 class="h3 mb-1">Return Requests</h1>
                                    <p class="text-muted mb-0">Track and manage your return requests</p>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('orders') }}" class="btn btn-outline-primary">
                                        <i class="fas fa-shopping-bag me-1"></i> My Orders
                                    </a>
                                    <a href="{{ route('returns.policy') }}" class="btn btn-primary">
                                        <i class="fas fa-file-contract me-1"></i> Return Policy
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <!-- Alert Messages -->
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show m-4" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show m-4" role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if ($returns->isEmpty())
                                <!-- Empty State -->
                                <div class="text-center py-5">
                                    <div class="mb-4">
                                        <i class="fas fa-exchange-alt fa-4x text-muted opacity-50"></i>
                                    </div>
                                    <h4 class="text-muted mb-3">No Return Requests</h4>
                                    <p class="text-muted mb-4">You haven't submitted any return requests yet.</p>
                                    <a href="{{ route('orders') }}" class="btn btn-primary">
                                        <i class="fas fa-shopping-bag me-2"></i> View My Orders
                                    </a>
                                </div>
                            @else
                                <!-- Returns Table -->
                                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="bg-light bg-opacity-50 position-sticky top-0">
                                            <tr>
                                                <th class="ps-4 py-4 text-primary" style="border-top-left-radius: 8px;">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-box-open me-2 fs-5"></i>
                                                        <span>PRODUCT</span>
                                                    </div>
                                                </th>
                                                <th class="ps-4 py-4 text-primary">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-info-circle me-2 fs-5"></i>
                                                        <span>RETURN INFO</span>
                                                    </div>
                                                </th>
                                                <th class="ps-4 py-4 text-primary">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-receipt me-2 fs-5"></i>
                                                        <span>ORDER DETAILS</span>
                                                    </div>
                                                </th>
                                                <th class="ps-4 py-4 text-primary">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-tasks me-2 fs-5"></i>
                                                        <span>STATUS</span>
                                                    </div>
                                                </th>
                                                <th class="text-center pe-4 py-4 text-primary"
                                                    style="border-top-right-radius: 8px;">
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-cogs me-2 fs-5"></i>
                                                        <span>ACTIONS</span>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($returns as $return)
                                                <tr class="border-bottom">
                                                    <!-- Product Column -->
                                                    <td class="ps-4">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 me-3">
                                                                @if ($return->product->image)
                                                                    <img src="{{ asset('uploads/products/' . $return->product->image) }}"
                                                                        alt="{{ $return->product->name }}"
                                                                        class="rounded border" width="50"
                                                                        height="50">
                                                                @else
                                                                    <div class="bg-light rounded border d-flex align-items-center justify-content-center"
                                                                        style="width: 50px; height: 50px;">
                                                                        <i class="fas fa-box text-muted"></i>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                {{-- <div class="fw-medium mb-1">
                                                                    <a href="{{ route('products.show', $return->product_id) }}" 
                                                                       class="text-decoration-none text-dark">
                                                                        {{ Str::limit($return->product->name, 25) }}
                                                                    </a>
                                                                </div> --}}
                                                                <div class="text-muted small">
                                                                    SKU: {{ $return->product->sku }}
                                                                </div>
                                                                <div class="text-muted small">
                                                                    Qty: {{ $return->quantity }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <!-- Return Info Column -->
                                                    <td>
                                                        <div class="mb-2">
                                                            <div class="text-muted small">Return ID</div>
                                                            <div class="fw-medium">
                                                                #RT{{ str_pad($return->id, 6, '0', STR_PAD_LEFT) }}</div>
                                                        </div>
                                                        <div>
                                                            <div class="text-muted small">Type</div>
                                                            @if ($return->return_type == 'refund')
                                                                <span
                                                                    class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-3">
                                                                    Refund
                                                                </span>
                                                            @elseif($return->return_type == 'replacement')
                                                                <span
                                                                    class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3">
                                                                    Replacement
                                                                </span>
                                                            @else
                                                                <span
                                                                    class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3">
                                                                    Store Credit
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </td>

                                                    <!-- Order Details Column -->
                                                    <td>
                                                        <div class="mb-2">
                                                            <div class="text-muted small">Order Number</div>
                                                            <a href="{{ route('order-details', $return->order->order_number) }}"
                                                                class="fw-medium text-decoration-none">
                                                                #{{ $return->order->order_number }}
                                                            </a>
                                                        </div>
                                                        <div>
                                                            <div class="text-muted small">Date Requested</div>
                                                            <div class="small">{{ $return->created_at->format('M d, Y') }}
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <!-- Status Column -->
                                                    <td>
                                                        @php
                                                            $statusColors = [
                                                                'pending' => ['bg' => 'warning', 'text' => 'warning'],
                                                                'approved' => ['bg' => 'success', 'text' => 'success'],
                                                                'processing' => ['bg' => 'info', 'text' => 'info'],
                                                                'completed' => ['bg' => 'primary', 'text' => 'primary'],
                                                                'rejected' => ['bg' => 'danger', 'text' => 'danger'],
                                                                'cancelled' => [
                                                                    'bg' => 'secondary',
                                                                    'text' => 'secondary',
                                                                ],
                                                            ];
                                                            $status = $return->status;
                                                            $color = $statusColors[$status] ?? [
                                                                'bg' => 'secondary',
                                                                'text' => 'secondary',
                                                            ];
                                                        @endphp
                                                        <div class="d-flex align-items-center">
                                                            <div class="badge-dot bg-{{ $color['bg'] }} me-2"></div>
                                                            <span class="fw-medium text-{{ $color['text'] }}">
                                                                {{ ucfirst($return->status) }}
                                                            </span>
                                                        </div>
                                                        @if ($return->status == 'approved')
                                                            <div class="small text-muted mt-1">
                                                                <i class="far fa-clock me-1"></i>
                                                                Processing
                                                            </div>
                                                        @endif
                                                    </td>

                                                    <!-- Actions Column -->
                                                    <td class="pe-4">
                                                        <div class="d-flex justify-content-center gap-2">
                                                            <a href="{{ route('returns.show', $return->id) }}"
                                                                class="btn btn-sm btn-outline-primary px-3"
                                                                title="View Details" data-bs-toggle="tooltip">
                                                                <i class="fas fa-eye me-1"></i> View
                                                            </a>
                                                            @if ($return->status == 'pending')
                                                                <form action="{{ route('returns.cancel', $return->id) }}"
                                                                    method="POST" class="d-inline"
                                                                    onsubmit="return confirm('Are you sure you want to cancel this return request?')">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-outline-danger px-3"
                                                                        title="Cancel Return" data-bs-toggle="tooltip">
                                                                        <i class="fas fa-times me-1"></i> Cancel
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                        @if ($return->updated_at && $return->status != 'pending')
                                                            <div class="text-center mt-2 small text-muted">
                                                                Updated: {{ $return->updated_at->format('M d') }}
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Summary Footer -->
                                <div class="row border-top m-0">
                                    <div class="col-md-8 py-3 ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="me-4">
                                                <div class="small text-muted">Total Returns</div>
                                                <div class="h5 mb-0">{{ $returns->total() }}</div>
                                            </div>
                                            <div class="vr"></div>
                                            <div class="mx-4">
                                                <div class="small text-muted">Pending</div>
                                                <div class="h5 mb-0 text-warning">
                                                    {{ $returns->where('status', 'pending')->count() }}
                                                </div>
                                            </div>
                                            <div class="vr"></div>
                                            <div class="mx-4">
                                                <div class="small text-muted">Completed</div>
                                                <div class="h5 mb-0 text-success">
                                                    {{ $returns->where('status', 'completed')->count() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 py-3 pe-4 text-end">
                                        <!-- Pagination -->
                                        <div class="d-flex justify-content-end align-items-center">
                                            <div class="me-3 small text-muted">
                                                Showing {{ $returns->firstItem() ?? 0 }}-{{ $returns->lastItem() ?? 0 }}
                                                of {{ $returns->total() }}
                                            </div>
                                            {{-- <div>
                                                {{ $returns->links('vendor.pagination.bootstrap-5') }}
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Stats Cards -->
                    @if (!$returns->isEmpty())
                        <div class="row mt-4">
                            <div class="col-md-3">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                                                <i class="fas fa-clock text-primary fa-lg"></i>
                                            </div>
                                            <div>
                                                <div class="text-muted small">Avg. Processing Time</div>
                                                <div class="h5 mb-0">3-5 Days</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success bg-opacity-10 rounded p-3 me-3">
                                                <i class="fas fa-check-circle text-success fa-lg"></i>
                                            </div>
                                            <div>
                                                <div class="text-muted small">Approval Rate</div>
                                                <div class="h5 mb-0">98%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-info bg-opacity-10 rounded p-3 me-3">
                                                <i class="fas fa-sync-alt text-info fa-lg"></i>
                                            </div>
                                            <div>
                                                <div class="text-muted small">Free Returns</div>
                                                <div class="h5 mb-0">On Defects</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-warning bg-opacity-10 rounded p-3 me-3">
                                                <i class="fas fa-headset text-warning fa-lg"></i>
                                            </div>
                                            <div>
                                                <div class="text-muted small">Need Help?</div>
                                                <a href="{{ route('contact') }}" class="h6 mb-0 text-decoration-none">
                                                    Contact Support <i class="fas fa-arrow-right ms-1 small"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@section('styles')
    <style>
        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            border-top: 1px solid #dee2e6;
        }

        .table td {
            vertical-align: middle;
            padding: 1rem 0.5rem;
        }

        .badge-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .table> :not(caption)>*>* {
            box-shadow: none;
        }

        .card {
            border: 1px solid rgba(0, 0, 0, 0.05);
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

        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            border-radius: 4px;
            margin: 0 2px;
        }

        @media (max-width: 992px) {
            .table-responsive {
                border: 0;
            }

            .table thead {
                display: none;
            }

            .table,
            .table tbody,
            .table tr,
            .table td {
                display: block;
                width: 100%;
            }

            .table tr {
                margin-bottom: 1rem;
                border: 1px solid #dee2e6 !important;
                border-radius: 8px;
            }

            .table td {
                text-align: right;
                padding-left: 50%;
                position: relative;
                border: none;
                border-bottom: 1px solid #f1f1f1;
            }

            .table td:last-child {
                border-bottom: 0;
            }

            .table td::before {
                content: attr(data-label);
                position: absolute;
                left: 1rem;
                width: calc(50% - 2rem);
                padding-right: 1rem;
                text-align: left;
                font-weight: 600;
                color: #666;
            }

            /* Mobile labels - you'll need to add data-label attributes to each td */
            .table td:first-child {
                padding-top: 1.5rem;
            }

            .table td:last-child {
                padding-bottom: 1.5rem;
            }
        }

        /* Status colors */
        .bg-warning {
            background-color: #ffc107 !important;
        }

        .text-warning {
            color: #ffc107 !important;
        }

        .bg-success {
            background-color: #198754 !important;
        }

        .text-success {
            color: #198754 !important;
        }

        .bg-info {
            background-color: #0dcaf0 !important;
        }

        .text-info {
            color: #0dcaf0 !important;
        }

        .bg-primary {
            background-color: #0d6efd !important;
        }

        .text-primary {
            color: #0d6efd !important;
        }

        .bg-danger {
            background-color: #dc3545 !important;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .bg-secondary {
            background-color: #6c757d !important;
        }

        .text-secondary {
            color: #6c757d !important;
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Add data-labels for mobile responsive table
            if (window.innerWidth < 992) {
                document.querySelectorAll('tbody tr td:nth-child(1)').forEach(td => {
                    td.setAttribute('data-label', 'Product');
                });
                document.querySelectorAll('tbody tr td:nth-child(2)').forEach(td => {
                    td.setAttribute('data-label', 'Return Info');
                });
                document.querySelectorAll('tbody tr td:nth-child(3)').forEach(td => {
                    td.setAttribute('data-label', 'Order Details');
                });
                document.querySelectorAll('tbody tr td:nth-child(4)').forEach(td => {
                    td.setAttribute('data-label', 'Status');
                });
                document.querySelectorAll('tbody tr td:nth-child(5)').forEach(td => {
                    td.setAttribute('data-label', 'Actions');
                });
            }
        });
    </script>
@endsection
