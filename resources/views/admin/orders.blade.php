@extends('admin.layouts.app')

@section('title', 'Manage Orders')

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Order Management</h1>
        <div class="d-flex gap-2">
            <!-- Export Button -->
            <button class="btn btn-outline-success btn-sm">
                <i class="fas fa-file-export me-1"></i> Export
            </button>
            <!-- Filter Dropdown -->
            <div class="dropdown">
                <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="?status=all">All Orders</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="?status=pending">Pending</a></li>
                    <li><a class="dropdown-item" href="?status=processing">Processing</a></li>
                    <li><a class="dropdown-item" href="?status=shipped">Shipped</a></li>
                    <li><a class="dropdown-item" href="?status=delivered">Delivered</a></li>
                    <li><a class="dropdown-item" href="?status=cancelled">Cancelled</a></li>
                </ul>
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

    <!-- Orders Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary">All Orders</h6>
            <!-- Search Box -->
            <div class="d-flex" style="max-width: 300px;">
                <input type="text" id="searchOrders" class="form-control form-control-sm" placeholder="Search orders...">
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="ordersTable" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th width="5%">Sr No</th>
                            <th width="15%">Order No</th>
                            <th width="20%">Customer</th>
                            <th width="15%">Date</th>
                            <th width="10%">Items</th>
                            <th width="10%">Total</th>
                            <th width="15%">Status</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong class="text-primary">{{ $order->order_number }}</strong>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="me-2">
                                        @if($order->user->profile_image)
                                        <img src="{{ asset('storage/profile-images/' . $order->user->profile_image) }}" 
                                             alt="{{ $order->user->name }}"
                                             class="rounded-circle"
                                             style="width: 32px; height: 32px; object-fit: cover;">
                                        @else
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                             style="width: 32px; height: 32px; font-size: 14px;">
                                            {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                        </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-medium">{{ $order->user->name }}</div>
                                        <small class="text-muted">{{ $order->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{ $order->created_at->format('d M Y') }}<br>
                                <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-secondary rounded-pill">
                                    {{ $order->items->count() }} items
                                </span>
                            </td>
                            <td class="fw-bold">₹{{ number_format($order->total, 2) }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-{{ $order->status_badge }} rounded-pill me-2">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                type="button" 
                                                data-bs-toggle="dropdown"
                                                style="padding: 0.15rem 0.5rem; font-size: 0.75rem;">
                                            <i class="fas fa-cog"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="#" 
                                                   onclick="updateStatus('{{ $order->id }}', 'pending')">
                                                    <i class="fas fa-clock text-warning me-2"></i> Pending
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#" 
                                                   onclick="updateStatus('{{ $order->id }}', 'processing')">
                                                    <i class="fas fa-cog text-info me-2"></i> Processing
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#" 
                                                   onclick="updateStatus('{{ $order->id }}', 'shipped')">
                                                    <i class="fas fa-truck text-primary me-2"></i> Shipped
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#" 
                                                   onclick="updateStatus('{{ $order->id }}', 'delivered')">
                                                    <i class="fas fa-check-circle text-success me-2"></i> Delivered
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="#" 
                                                   onclick="updateStatus('{{ $order->id }}', 'cancelled')">
                                                    <i class="fas fa-times-circle me-2"></i> Cancel
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.order.details', $order->id) }}" 
                                       class="btn btn-sm btn-info" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.order.invoice', $order->id) }}" 
                                       class="btn btn-sm btn-success" title="Download Invoice">
                                        <i class="fas fa-file-invoice"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-warning" 
                                            title="Send Update"
                                            onclick="sendUpdate('{{ $order->id }}')">
                                        <i class="fas fa-envelope"></i>
                                    </button>
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
            @if($orders->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted small">
                    Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} orders
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
        box-shadow: 0 0 15px rgba(0,0,0,0.08);
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
    
    .border-left-primary { border-left: 0.25rem solid #4e73df !important; }
    .border-left-success { border-left: 0.25rem solid #1cc88a !important; }
    .border-left-warning { border-left: 0.25rem solid #f6c23e !important; }
    .border-left-info { border-left: 0.25rem solid #36b9cc !important; }
    
    .btn-group .btn {
        border-radius: 4px !important;
        margin: 0 2px;
    }
    
    .dropdown-menu {
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
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
                body: JSON.stringify({ status: status })
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
                body: JSON.stringify({ message: message })
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