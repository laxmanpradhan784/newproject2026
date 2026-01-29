@extends('admin.layouts.app')

@section('title', 'Manage Orders')

@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold text-primary mb-1">Order Management</h3>
                    <p class="text-muted mb-0">Manage your Orders</p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <!-- Export Button -->
                <button class="btn btn-outline-success btn-sm">
                    <i class="fas fa-file-export me-1"></i> Export
                </button>
                <!-- Filter Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-filter me-1"></i>
                        {{ request('status', 'all') == 'all' ? 'All Orders' : ucfirst(request('status')) }}
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ !request('status') || request('status') == 'all' ? 'active' : '' }}"
                                href="{{ route('admin.orders', ['search' => request('search'), 'status' => 'all']) }}">
                                All Orders
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item {{ request('status') == 'pending' ? 'active' : '' }}"
                                href="{{ route('admin.orders', ['search' => request('search'), 'status' => 'pending']) }}">
                                Pending
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request('status') == 'processing' ? 'active' : '' }}"
                                href="{{ route('admin.orders', ['search' => request('search'), 'status' => 'processing']) }}">
                                Processing
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request('status') == 'shipped' ? 'active' : '' }}"
                                href="{{ route('admin.orders', ['search' => request('search'), 'status' => 'shipped']) }}">
                                Shipped
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request('status') == 'delivered' ? 'active' : '' }}"
                                href="{{ route('admin.orders', ['search' => request('search'), 'status' => 'delivered']) }}">
                                Delivered
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request('status') == 'cancelled' ? 'active' : '' }}"
                                href="{{ route('admin.orders', ['search' => request('search'), 'status' => 'cancelled']) }}">
                                Cancelled
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                                Total Orders
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $totalOrders }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">
                                Today's Orders
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $todayOrders }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">
                                Pending Orders
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $pendingOrders }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-info text-uppercase mb-1">
                                Revenue
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">₹{{ number_format($totalRevenue, 2) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-rupee-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .table-responsive {
            max-height: 400px;
            overflow-y: auto;
        }

        #ordersTable thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background-color: #f8f9fa;
            /* same as bg-light */
        }
    </style>

    <!-- Orders Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary">All Orders</h6>
            <!-- Search Box -->
            <!-- Search Box -->
            <form method="GET" action="{{ route('admin.orders') }}" class="d-flex" style="max-width: 400px;">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" id="searchOrders"
                        class="form-control form-control-sm border-start-0" placeholder="Search by order ID......"
                        value="{{ request('search') }}" data-bs-toggle="tooltip"
                        data-bs-title="Search by: User name, Order ID (ORD-), Date (YYYY-MM-DD), Payment (cod/card/upi)">
                    @if (request('search'))
                    @endif
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                <table class="table table-bordered table-hover" id="ordersTable" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr class="bg-light bg-gradient border-bottom border-3">
                            <th class="ps-4 py-3 align-middle fw-semibold text-dark" width="5%">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                        <i class="bi bi-hash text-primary fs-6"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold">No</span>
                                    </div>
                                </div>
                            </th>
                            <th class="py-3 align-middle fw-semibold text-dark" width="15%">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                        <i class="bi bi-receipt text-primary fs-6"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold">Order No</span>
                                        <small class="text-muted">ID</small>
                                    </div>
                                </div>
                            </th>
                            <th class="py-3 align-middle fw-semibold text-dark" width="20%">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                        <i class="bi bi-person-circle text-primary fs-6"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold">Customer</span>
                                        <small class="text-muted">Details</small>
                                    </div>
                                </div>
                            </th>
                            <th class="py-3 align-middle fw-semibold text-dark" width="15%">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                        <i class="bi bi-calendar-event text-primary fs-6"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold">Date</span>
                                        <small class="text-muted">Order Date</small>
                                    </div>
                                </div>
                            </th>
                            <th class="py-3 align-middle fw-semibold text-dark" width="10%">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                        <i class="bi bi-box-seam text-primary fs-6"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold">Items</span>
                                        <small class="text-muted">Qty</small>
                                    </div>
                                </div>
                            </th>
                            <th class="py-3 align-middle fw-semibold text-dark" width="10%">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                        <i class="bi bi-currency-rupee text-primary fs-6"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold">Total</span>
                                        <small class="text-muted">Amount</small>
                                    </div>
                                </div>
                            </th>
                            <th class="py-3 align-middle fw-semibold text-dark" width="15%">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                        <i class="bi bi-truck text-primary fs-6"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold">Status</span>
                                        <small class="text-muted">Delivery</small>
                                    </div>
                                </div>
                            </th>
                            <th class="pe-4 py-3 align-middle fw-semibold text-dark text-end" width="10%">
                                <div class="d-flex align-items-center justify-content-end gap-2">
                                    <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                        <i class="bi bi-gear text-primary fs-6"></i>
                                    </div>
                                    <div class="d-flex flex-column text-end">
                                        <span class="fw-semibold">Actions</span>
                                        <small class="text-muted">Manage</small>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td class="ps-4 py-3 align-middle">
                                    <span
                                        class="badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill px-3 py-1 fw-medium">
                                        {{ $loop->iteration }}
                                    </span>
                                </td>
                                <td class="py-3 align-middle">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                            style="width: 40px; height: 40px;">
                                            <i class="bi bi-receipt"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-primary">{{ $order->order_number }}</div>
                                            <small class="text-muted">Order ID</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 align-middle">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                            style="width: 42px; height: 42px;">
                                            <i class="bi bi-person fs-5"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark mb-1">{{ $order->user->name }}</div>
                                            <div class="text-muted small d-flex align-items-center gap-1">
                                                <i class="bi bi-envelope"></i>
                                                {{ $order->user->email }}
                                            </div>
                                            @if ($order->user->phone)
                                                <div class="text-muted small d-flex align-items-center gap-1 mt-1">
                                                    <i class="bi bi-telephone"></i>
                                                    {{ $order->user->phone }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 align-middle">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-light border rounded-3 px-3 py-2 mb-2">
                                            <div class="text-center">
                                                <div class="fw-semibold text-dark">{{ $order->created_at->format('d M') }}
                                                </div>
                                                <small class="text-muted">{{ $order->created_at->format('Y') }}</small>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-1">
                                            <i class="bi bi-clock text-muted small"></i>
                                            <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="position-relative">
                                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px;">
                                                <i class="bi bi-cart fs-4"></i>
                                            </div>
                                            <span
                                                class="position-absolute top-0 start-100 translate-middle badge bg-danger rounded-pill">
                                                {{ $order->items->count() }}
                                            </span>
                                        </div>
                                        <small class="text-muted mt-2">{{ $order->items->count() }} item(s)</small>
                                    </div>
                                </td>
                                <td class="py-3 align-middle">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                            style="width: 40px; height: 40px;">
                                            <i class="bi bi-currency-rupee fs-5"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">₹{{ number_format($order->total, 2) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 align-middle">
                                    <div class="d-flex flex-column gap-2">
                                        <!-- Current Status Badge -->
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'processing' => 'info',
                                                'shipped' => 'primary',
                                                'delivered' => 'success',
                                                'cancelled' => 'danger',
                                            ];

                                            $statusIcons = [
                                                'pending' => 'bi-clock',
                                                'processing' => 'bi-gear',
                                                'shipped' => 'bi-truck',
                                                'delivered' => 'bi-check-circle',
                                                'cancelled' => 'bi-x-circle',
                                            ];
                                        @endphp

                                        <span
                                            class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }} 
                  rounded-pill py-2 px-3 d-inline-flex align-items-center gap-2">
                                            <i class="bi {{ $statusIcons[$order->status] ?? 'bi-question' }}"></i>
                                            {{ ucfirst($order->status) }}
                                            @if ($order->delivered_at)
                                                <small class="text-white-50 ms-1">
                                                    ({{ \Carbon\Carbon::parse($order->delivered_at)->format('d M') }})
                                                </small>
                                            @endif
                                        </span>

                                        <!-- Status Selector -->
                                        <form action="{{ route('admin.order.status.update', $order->id) }}"
                                            method="POST" class="w-100">
                                            @csrf
                                            @method('PUT')
                                            <select name="status"
                                                class="form-select form-select-sm border-{{ $statusColors[$order->status] ?? 'secondary' }}"
                                                onchange="if(confirm('Change order status to ' + this.value + '?')) this.form.submit()">
                                                <option value="pending"
                                                    {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="processing"
                                                    {{ $order->status == 'processing' ? 'selected' : '' }}>Processing
                                                </option>
                                                <option value="shipped"
                                                    {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                <option value="delivered"
                                                    {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered
                                                </option>
                                                <option value="cancelled"
                                                    {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                                                </option>
                                            </select>
                                        </form>
                                    </div>
                                </td>
                                <td class="py-3 align-middle text-end">
                                    <div class="btn-group" role="group">
                                        <!-- View Details -->
                                        <a href="{{ route('admin.order.details', $order->id) }}"
                                            class="btn btn-sm btn-outline-info rounded-start d-flex align-items-center justify-content-center"
                                            style="width: 60px; height: 40px;" title="View Order Details"
                                            data-bs-toggle="tooltip">
                                            <i class="bi bi-eye fs-6"></i>
                                        </a>

                                        <!-- Download Invoice -->
                                        <a href="{{ route('admin.order.invoice', $order->id) }}"
                                            class="btn btn-sm btn-outline-success d-flex align-items-center justify-content-center"
                                            style="width: 60px; height: 40px;" title="Download Invoice"
                                            data-bs-toggle="tooltip">
                                            <i class="bi bi-receipt fs-6"></i>
                                        </a>

                                        <!-- Send Update -->
                                        {{-- <button type="button"
                                            class="btn btn-sm btn-outline-warning d-flex align-items-center justify-content-center"
                                            style="width: 40px; height: 40px;" title="Send Status Update"
                                            data-bs-toggle="tooltip"
                                            onclick="sendUpdate('{{ $order->id }}', '{{ $order->shipping_email }}')">
                                            <i class="bi bi-envelope fs-6"></i>
                                        </button> --}}

                                        <!-- Delete Order -->
                                        {{-- <button type="button"
                                            class="btn btn-sm btn-outline-danger rounded-end d-flex align-items-center justify-content-center"
                                            style="width: 40px; height: 40px;" title="Delete Order"
                                            data-bs-toggle="tooltip" data-bs-toggle="modal"
                                            data-bs-target="#deleteOrderModal"
                                            onclick="setDeleteOrderId('{{ $order->id }}')">
                                            <i class="bi bi-trash fs-6"></i>
                                        </button> --}}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <h5>No Orders Found</h5>
                                        <p>No orders have been placed yet.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($orders->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }}
                        orders
                    </div>
                    <nav>
                        {{ $orders->links() }}
                    </nav>
                </div>
            @endif
        </div>
    </div>
    </div>
@endsection

@push('styles')
    <style>
        .card {
            border: none;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.08);
            border-radius: 10px;
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #e3e6f0;
            border-radius: 10px 10px 0 0 !important;
        }

        .table th {
            font-weight: 600;
            color: #4e73df;
            border-top: none;
            padding: 1rem;
        }

        .table td {
            vertical-align: middle;
            padding: 1rem;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(78, 115, 223, 0.05);
            cursor: pointer;
        }

        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
            font-size: 0.85em;
        }

        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }

        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }

        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }

        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }

        .btn-group .btn {
            border-radius: 4px !important;
            margin: 0 2px;
        }

        .dropdown-menu {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border: none;
            border-radius: 8px;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .dropdown-item:hover {
            background-color: #4e73df;
            color: white;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.getElementById('searchOrders');
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase();
                    const rows = document.querySelectorAll('#ordersTable tbody tr');

                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                });
            }

            // Sort by column click
            const headers = document.querySelectorAll('#ordersTable th');
            headers.forEach((header, index) => {
                header.style.cursor = 'pointer';
                header.addEventListener('click', () => {
                    sortTable(index);
                });
            });
        });

        // Update order status
        function updateStatus(orderId, status) {
            if (confirm('Are you sure you want to update the order status?')) {
                fetch(`/admin/orders/${orderId}/status`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            status: status
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Error updating status');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Network error');
                    });
            }
        }

        // Send order update email
        function sendUpdate(orderId) {
            const message = prompt('Enter update message for the customer:');
            if (message) {
                fetch(`/admin/orders/${orderId}/notify`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            message: message
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Notification sent successfully');
                        } else {
                            alert('Error sending notification');
                        }
                    });
            }
        }

        // Sort table
        function sortTable(column) {
            const table = document.getElementById('ordersTable');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));

            rows.sort((a, b) => {
                const aText = a.cells[column].textContent.trim();
                const bText = b.cells[column].textContent.trim();

                // Check if values are numeric
                const aNum = parseFloat(aText.replace(/[^0-9.-]+/g, ''));
                const bNum = parseFloat(bText.replace(/[^0-9.-]+/g, ''));

                if (!isNaN(aNum) && !isNaN(bNum)) {
                    return aNum - bNum;
                }

                return aText.localeCompare(bText);
            });

            // Remove all rows and re-add in sorted order
            rows.forEach(row => tbody.appendChild(row));
        }

        // Auto-refresh every 30 seconds
        setInterval(() => {
            if (!document.hidden) {
                // Optional: Only refresh if needed
                // location.reload();
            }
        }, 30000);
    </script>
@endpush
