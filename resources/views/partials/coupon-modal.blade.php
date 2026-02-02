<!-- Modern Coupon Modal -->
<div class="modal fade" id="couponModal" tabindex="-1" aria-labelledby="couponModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 pb-1 pt-4 px-4">
                <div class="w-100">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="modal-title fw-bold" id="couponModalLabel">
                            <i class="fas fa-tag text-primary me-2"></i>Available Coupons
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <p class="text-muted small mb-0">Select or copy a coupon code to apply</p>
                </div>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    @forelse($availableCoupons as $coupon)
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm hover-lift transition-all">
                            <div class="card-body p-3">
                                <!-- Coupon Header -->
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-3 py-1 fw-normal">
                                            <i class="fas fa-ticket-alt me-1 fa-sm"></i>{{ $coupon->code }}
                                        </span>
                                        @if($coupon->status != 'active')
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill px-2 py-1">
                                                Expired
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Coupon Title & Description -->
                                <h6 class="fw-bold mb-2 text-dark">{{ $coupon->name }}</h6>
                                <p class="small text-muted mb-3">{{ Str::limit($coupon->description, 80) }}</p>

                                <!-- Discount Value -->
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <span class="bg-success bg-opacity-10 text-success rounded-2 px-3 py-1 fw-bold">
                                        @if($coupon->discount_type == 'percentage')
                                            {{ $coupon->discount_value }}% OFF
                                        @else
                                            ₹{{ $coupon->discount_value }} OFF
                                        @endif
                                    </span>
                                </div>

                                <!-- Conditions -->
                                <div class="coupon-conditions">
                                    <div class="d-flex flex-wrap gap-2 mb-2">
                                        @if($coupon->min_order_amount > 0)
                                            <span class="badge bg-light text-dark border border-1 rounded-pill px-2 py-1">
                                                <i class="fas fa-shopping-bag me-1 fa-xs"></i>Min. ₹{{ $coupon->min_order_amount }}
                                            </span>
                                        @endif
                                        @if($coupon->max_discount_amount)
                                            <span class="badge bg-light text-dark border border-1 rounded-pill px-2 py-1">
                                                <i class="fas fa-chart-line me-1 fa-xs"></i>Max. ₹{{ $coupon->max_discount_amount }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <div class="d-flex align-items-center text-muted small">
                                        <i class="fas fa-calendar-alt me-1 fa-xs"></i>
                                        <span>Valid till {{ \Carbon\Carbon::parse($coupon->end_date)->format('d M, Y') }}</span>
                                    </div>
                                    
                                    @if($coupon->usage_limit_per_user)
                                        <div class="d-flex align-items-center text-muted small mt-1">
                                            <i class="fas fa-user me-1 fa-xs"></i>
                                            <span>{{ $coupon->usage_limit_per_user }} use{{ $coupon->usage_limit_per_user > 1 ? 's' : '' }} per user</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="card-footer bg-transparent border-top pt-3 px-3 pb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3 copy-coupon" data-code="{{ $coupon->code }}">
                                        <i class="fas fa-copy me-1"></i>Copy
                                    </button>
                                    
                                    @if($coupon->status == 'active')
                                        <form action="{{ route('coupon.apply') }}" method="POST" class="m-0">
                                            @csrf
                                            <input type="hidden" name="coupon_code" value="{{ $coupon->code }}">
                                            <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4">
                                                Apply Now
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                                <i class="fas fa-tag text-muted fa-2x"></i>
                            </div>
                            <h5 class="fw-bold mb-2">No coupons available</h5>
                            <p class="text-muted mb-4">New coupons will be added soon</p>
                            <button type="button" class="btn btn-outline-primary rounded-pill px-4" data-bs-dismiss="modal">
                                Continue Shopping
                            </button>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
            
            @if($availableCoupons->count() > 0)
            <div class="modal-footer border-0 pt-1 pb-4 px-4">
                <div class="w-100 text-center">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Coupons can be applied at checkout
                    </small>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .modal-content {
        border-radius: 16px !important;
        overflow: hidden;
    }
    
    .hover-lift {
        transition: all 0.2s ease;
        border-radius: 12px;
    }
    
    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
    }
    
    .modal-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    }
    
    .coupon-conditions .badge {
        font-size: 0.75rem;
        border-color: #e9ecef !important;
    }
    
    .btn-sm {
        padding: 0.35rem 0.75rem;
        font-size: 0.85rem;
    }
    
    .bg-opacity-10 {
        --bs-bg-opacity: 0.1;
    }
    
    .border-opacity-25 {
        --bs-border-opacity: 0.25;
    }
    
    .transition-all {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .rounded-2 {
        border-radius: 8px !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Enhanced copy coupon code with toast
        document.querySelectorAll('.copy-coupon').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const code = this.getAttribute('data-code');
                const originalHTML = this.innerHTML;
                
                // Copy to clipboard
                navigator.clipboard.writeText(code).then(() => {
                    // Visual feedback
                    this.innerHTML = '<i class="fas fa-check me-1"></i>Copied!';
                    this.classList.remove('btn-outline-dark');
                    this.classList.add('btn-success');
                    
                    // Show temporary toast
                    showCopySuccess(code);
                    
                    // Reset button after 2 seconds
                    setTimeout(() => {
                        this.innerHTML = originalHTML;
                        this.classList.remove('btn-success');
                        this.classList.add('btn-outline-dark');
                    }, 2000);
                }).catch(err => {
                    console.error('Failed to copy: ', err);
                    this.innerHTML = '<i class="fas fa-times me-1"></i>Failed';
                    this.classList.remove('btn-outline-dark');
                    this.classList.add('btn-danger');
                    
                    setTimeout(() => {
                        this.innerHTML = originalHTML;
                        this.classList.remove('btn-danger');
                        this.classList.add('btn-outline-dark');
                    }, 2000);
                });
            });
        });
        
        function showCopySuccess(code) {
            // Create toast element
            const toast = document.createElement('div');
            toast.className = 'position-fixed bottom-0 start-50 translate-middle-x mb-3';
            toast.style.zIndex = '9999';
            
            toast.innerHTML = `
                <div class="alert alert-success d-flex align-items-center shadow-lg border-0 rounded-pill px-4 py-2 animate__animated animate__fadeInUp" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <div>
                        <strong>Copied!</strong> Code: <code class="bg-white bg-opacity-25 px-2 py-1 rounded">${code}</code>
                    </div>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            // Remove toast after 3 seconds
            setTimeout(() => {
                toast.classList.add('animate__fadeOutDown');
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 500);
            }, 3000);
        }
    });
</script>