@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<section class="my-orders py-5 bg-light">
    <div class="container pt-5">
        <!-- Breadcrumb with improved styling -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="d-flex flex-column gap-3">
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
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                                <i class="fas fa-receipt me-1"></i>
                                {{ $orders->total() }} Order{{ $orders->total() > 1 ? 's' : '' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($orders->count() > 0)
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-0 py-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="h5 mb-0 fw-semibold">Order History</h2>
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-muted small">
                                    Showing {{ $orders->firstItem() }}-{{ $orders->lastItem() }} of {{ $orders->total() }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light bg-opacity-50">
                                    <tr>
                                        <th class="py-3 px-4 border-0 fw-semibold text-muted text-uppercase small">Order #</th>
                                        <th class="py-3 px-4 border-0 fw-semibold text-muted text-uppercase small">Date</th>
                                        <th class="py-3 px-4 border-0 fw-semibold text-muted text-uppercase small">Items</th>
                                        <th class="py-3 px-4 border-0 fw-semibold text-muted text-uppercase small">Total</th>
                                        <th class="py-3 px-4 border-0 fw-semibold text-muted text-uppercase small">Status</th>
                                        <th class="py-3 px-4 border-0 fw-semibold text-muted text-uppercase small">Payment</th>
                                        <th class="py-3 px-4 border-0 fw-semibold text-muted text-uppercase small text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr class="border-bottom">
                                        <td class="py-4 px-4">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                                    <i class="fas fa-receipt text-primary fs-6"></i>
                                                </div>
                                                <div>
                                                    <strong class="d-block">{{ $order->order_number }}</strong>
                                                    <small class="text-muted">{{ $order->payment_method }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="d-flex flex-column">
                                                <span class="fw-medium">{{ $order->created_at->format('d M Y') }}</span>
                                                <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge bg-secondary bg-opacity-10 text-dark rounded-pill px-3 py-1">
                                                    {{ $order->items->count() }} items
                                                </span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="fw-bold fs-5 text-dark">₹{{ number_format($order->total, 2) }}</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="badge bg-{{ $order->status_badge }} bg-opacity-25 text-dark border border-{{ $order->status_badge }} rounded-pill px-3 py-2">
                                                <i class="fas fa-circle-small me-1"></i>
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }} bg-opacity-25 text-dark border border-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }} rounded-pill px-3 py-2">
                                                <i class="fas fa-{{ $order->payment_status == 'paid' ? 'check-circle' : 'clock' }} me-1"></i>
                                                {{ ucfirst($order->payment_status) }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 text-end">
                                            <a href="{{ route('order-details', $order->order_number) }}" 
                                               class="btn btn-sm btn-outline-dark border-2 px-4 py-2 rounded-3 fw-medium">
                                                <i class="fas fa-eye me-2"></i>View Details
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination with improved styling -->
                        @if($orders->hasPages())
                        <div class="card-footer bg-white border-0 py-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted small">
                                    Page {{ $orders->currentPage() }} of {{ $orders->lastPage() }}
                                </div>
                                <nav aria-label="Order pagination">
                                    {{ $orders->onEachSide(1)->links('vendor.pagination.custom') }}
                                </nav>
                            </div>
                        </div>
                        @endif
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
                        <p class="text-muted mb-4 px-3">Looks like you haven't made any purchases yet. Discover amazing products and make your first order!</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('products') }}" class="btn btn-primary btn-lg px-4 py-3 rounded-3 fw-semibold">
                                <i class="fas fa-shopping-cart me-2"></i>Start Shopping
                            </a>
                            <a href="{{ route('home') }}" class="btn btn-outline-dark btn-lg px-4 py-3 rounded-3 fw-semibold">
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
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
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
</style>
@endpush
@endsection