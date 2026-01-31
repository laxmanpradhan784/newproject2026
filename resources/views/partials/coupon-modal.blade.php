<!-- Coupon Modal -->
<div class="modal fade" id="couponModal" tabindex="-1" aria-labelledby="couponModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="couponModalLabel">Available Coupons</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @forelse($availableCoupons as $coupon)
                    <div class="col-md-6 mb-3">
                        <div class="card coupon-card h-100 border-{{ $coupon->status == 'active' ? 'success' : 'secondary' }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <span class="badge bg-primary mb-2">{{ $coupon->code }}</span>
                                        <h6 class="card-title">{{ $coupon->name }}</h6>
                                        <p class="card-text small text-muted">{{ $coupon->description }}</p>
                                        
                                        <div class="mb-2">
                                            @if($coupon->discount_type == 'percentage')
                                                <span class="fw-bold text-success">{{ $coupon->discount_value }}% OFF</span>
                                            @else
                                                <span class="fw-bold text-success">₹{{ $coupon->discount_value }} OFF</span>
                                            @endif
                                        </div>
                                        
                                        <div class="coupon-conditions small">
                                            @if($coupon->min_order_amount > 0)
                                                <p class="mb-1"><i class="bi bi-check-circle-fill text-success"></i> Min. order: ₹{{ $coupon->min_order_amount }}</p>
                                            @endif
                                            @if($coupon->max_discount_amount)
                                                <p class="mb-1"><i class="bi bi-check-circle-fill text-success"></i> Max. discount: ₹{{ $coupon->max_discount_amount }}</p>
                                            @endif
                                            <p class="mb-1"><i class="bi bi-calendar"></i> Valid till: {{ \Carbon\Carbon::parse($coupon->end_date)->format('d M, Y') }}</p>
                                            @if($coupon->usage_limit)
                                                <p class="mb-1"><i class="bi bi-person"></i> Limited to {{ $coupon->usage_limit_per_user }} use{{ $coupon->usage_limit_per_user > 1 ? 's' : '' }} per user</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-top-0">
                                <form action="{{ route('coupon.apply') }}" method="POST" class="d-flex justify-content-between">
                                    @csrf
                                    <input type="hidden" name="coupon_code" value="{{ $coupon->code }}">
                                    <button type="button" class="btn btn-outline-primary btn-sm copy-coupon" data-code="{{ $coupon->code }}">
                                        <i class="bi bi-clipboard"></i> Copy Code
                                    </button>
                                    @if($coupon->status == 'active')
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            Apply
                                        </button>
                                    @else
                                        <span class="badge bg-secondary">Expired</span>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="text-center py-4">
                            <i class="bi bi-tag display-1 text-muted"></i>
                            <h5 class="mt-3">No coupons available</h5>
                            <p class="text-muted">Check back later for new offers</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .coupon-card {
        transition: transform 0.3s;
    }
    .coupon-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Copy coupon code
        document.querySelectorAll('.copy-coupon').forEach(button => {
            button.addEventListener('click', function() {
                const code = this.getAttribute('data-code');
                navigator.clipboard.writeText(code).then(() => {
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="bi bi-check"></i> Copied!';
                    setTimeout(() => {
                        this.innerHTML = originalText;
                    }, 2000);
                });
            });
        });
    });
</script>