@extends('layouts.app')

@section('title', 'Return & Refund Policy')

@section('content')
<div class="container py-4">
    <!-- Quick Stats Bar -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-3">
                    <div class="row g-3 text-center">
                        <div class="col-md-3">
                            <div class="d-flex flex-column align-items-center">
                                <span class="display-6 fw-bold text-primary">{{ $policy->return_window_days }}</span>
                                <span class="text-muted small">Day Return Window</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex flex-column align-items-center">
                                <span class="display-6 fw-bold text-success">5-7</span>
                                <span class="text-muted small">Day Refund Time</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex flex-column align-items-center">
                                <span class="display-6 fw-bold text-warning">Free</span>
                                <span class="text-muted small">Defect Returns</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex flex-column align-items-center">
                                <span class="display-6 fw-bold text-info">24/7</span>
                                <span class="text-muted small">Support</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row g-4">
        <!-- Left Sidebar - Quick Actions -->
        <div class="col-lg-3">
            <div class="sticky-top" style="top: 20px;">
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-body">
                        <h6 class="mb-3 fw-bold">Quick Actions</h6>
                        <button class="btn btn-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#policyModal">
                            <i class="fas fa-file-alt me-2"></i>View Full Policy
                        </button>
                        {{-- <a href="{{ route('orders.index') }}" class="btn btn-outline-primary w-100 mb-2">
                            <i class="fas fa-shopping-bag me-2"></i>My Orders
                        </a> --}}
                        <a href="{{ route('contact') }}" class="btn btn-outline-primary w-100 mb-2">
                            <i class="fas fa-headset me-2"></i>Contact Support
                        </a>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="mb-3 fw-bold">Policy Summary</h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <small>{{ $policy->return_window_days }} day window</small>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <small>Free defect returns</small>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <small>Full refunds</small>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <small>Online process</small>
                            </li>
                            <li>
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <small>Quick approval</small>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col-lg-9">
            <!-- Policy Overview -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h2 class="h4 fw-bold mb-1">{{ $policy->name }}</h2>
                            <p class="text-muted mb-0">Last updated: {{ $policy->updated_at->format('F d, Y') }}</p>
                        </div>
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#policyModal">
                            <i class="fas fa-expand-alt me-2"></i>Expand View
                        </button>
                    </div>
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3">📦 Return Process</h6>
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                                            1
                                        </div>
                                        <div>
                                            <small class="fw-bold d-block">Initiate Return</small>
                                            <small class="text-muted">Via My Orders page</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                                            2
                                        </div>
                                        <div>
                                            <small class="fw-bold d-block">Get Approval</small>
                                            <small class="text-muted">Within 24-48 hours</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                                            3
                                        </div>
                                        <div>
                                            <small class="fw-bold d-block">Complete Return</small>
                                            <small class="text-muted">Ship & get refund</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3">💰 Refund Methods</h6>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-credit-card text-success me-3"></i>
                                        <div>
                                            <small class="fw-bold d-block">Original Payment</small>
                                            <small class="text-muted">5-7 business days</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-wallet text-warning me-3"></i>
                                        <div>
                                            <small class="fw-bold d-block">Store Credit</small>
                                            <small class="text-muted">Instant processing</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-exchange-alt text-info me-3"></i>
                                        <div>
                                            <small class="fw-bold d-block">Replacement</small>
                                            <small class="text-muted">Priority shipping</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="h5 fw-bold mb-4">❓ Frequently Asked Questions</h4>
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item border-0 mb-2">
                            <h6 class="accordion-header">
                                <button class="accordion-button border rounded py-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    How long does the return process take?
                                </button>
                            </h6>
                            <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body pt-2">
                                    <small class="text-muted">The entire process typically takes 10-14 days from initiation to refund. Returns are processed within 24-48 hours of receipt.</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item border-0 mb-2">
                            <h6 class="accordion-header">
                                <button class="accordion-button border rounded py-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    What items are not returnable?
                                </button>
                            </h6>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body pt-2">
                                    <small class="text-muted">Personalized items, digital products, gift cards, clearance items, and products damaged due to misuse are not eligible for return.</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item border-0 mb-2">
                            <h6 class="accordion-header">
                                <button class="accordion-button border rounded py-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Can I exchange an item instead of refund?
                                </button>
                            </h6>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body pt-2">
                                    <small class="text-muted">Yes! During the return process, select "replacement" as your return type. We'll ship the replacement as soon as your return is approved.</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item border-0">
                            <h6 class="accordion-header">
                                <button class="accordion-button border rounded py-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    What if my item arrives damaged?
                                </button>
                            </h6>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body pt-2">
                                    <small class="text-muted">Contact us within 48 hours with photos of the damaged item. We'll arrange a free return and replacement at no cost to you.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom CTA -->
    <div class="text-center mt-5">
        <h5 class="fw-bold mb-3">Need Help with Your Return?</h5>
        <p class="text-muted mb-4">Our support team is here to help you with any questions.</p>
        <div class="d-flex flex-wrap justify-content-center gap-2">
            <a href="tel:+15551234567" class="btn btn-outline-primary">
                <i class="fas fa-phone me-2"></i>Call Support
            </a>
            <a href="mailto:support@example.com" class="btn btn-outline-primary">
                <i class="fas fa-envelope me-2"></i>Email Us
            </a>
            <a href="{{ route('contact') }}" class="btn btn-primary">
                <i class="fas fa-comments me-2"></i>Live Chat
            </a>
        </div>
    </div>
</div>

<!-- Policy Modal -->
<div class="modal fade" id="policyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-0">
                <div>
                    <h5 class="modal-title fw-bold">{{ $policy->name }}</h5>
                    <p class="text-muted mb-0 small">Last updated: {{ $policy->updated_at->format('F d, Y') }}</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Original Policy Content Here -->
                <div class="row g-4">
                    <div class="col-lg-8">
                        <!-- Overview -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white py-3">
                                <h4 class="mb-0"><i class="fas fa-info-circle text-primary me-2"></i>Overview</h4>
                            </div>
                            <div class="card-body">
                                <p>We want you to be completely satisfied with your purchase. If you're not happy with your order, we're here to help. Our return policy is designed to be fair and transparent.</p>
                                
                                <div class="row mt-4">
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                <i class="fas fa-check text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">Easy Returns</h6>
                                                <p class="small text-muted mb-0">Simple online process</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                <i class="fas fa-shield-alt text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">Quality Guarantee</h6>
                                                <p class="small text-muted mb-0">Full refund for defective items</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                <i class="fas fa-truck text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">Free Returns</h6>
                                                <p class="small text-muted mb-0">On manufacturing defects</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                <i class="fas fa-clock text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">Quick Processing</h6>
                                                <p class="small text-muted mb-0">5-7 business day refunds</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Eligibility -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white py-3">
                                <h4 class="mb-0"><i class="fas fa-clipboard-check text-primary me-2"></i>Eligibility Criteria</h4>
                            </div>
                            <div class="card-body">
                                <p>To be eligible for a return, your item must meet the following conditions:</p>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item border-0 px-0">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Unused and in original condition
                                    </li>
                                    <li class="list-group-item border-0 px-0">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        In original packaging with all tags
                                    </li>
                                    <li class="list-group-item border-0 px-0">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Within {{ $policy->return_window_days }} days of delivery
                                    </li>
                                    <li class="list-group-item border-0 px-0">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Proof of purchase (order number) available
                                    </li>
                                </ul>
                                
                                <div class="alert alert-warning mt-4">
                                    <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Non-Returnable Items</h6>
                                    <ul class="mb-0">
                                        <li>Personalized or custom-made products</li>
                                        <li>Digital products, software, and gift cards</li>
                                        <li>Items marked as "Final Sale" or "Clearance"</li>
                                        <li>Products damaged due to misuse or improper care</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <!-- Refund Information -->
                        <div class="card shadow-sm">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0"><i class="fas fa-dollar-sign text-primary me-2"></i>Refund Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <h6 class="text-muted mb-2">Refund Methods</h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="fas fa-credit-card text-success me-2"></i>
                                            Original payment method
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-wallet text-warning me-2"></i>
                                            Store credit (instant)
                                        </li>
                                        <li>
                                            <i class="fas fa-exchange-alt text-info me-2"></i>
                                            Product replacement
                                        </li>
                                    </ul>
                                </div>
                                
                                <div class="mb-3">
                                    <h6 class="text-muted mb-2">Processing Time</h6>
                                    <p class="mb-0">Refunds are processed within 5-7 business days after we receive and inspect the returned item.</p>
                                </div>
                                
                                <div class="alert alert-info">
                                    <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Shipping Costs</h6>
                                    <p class="mb-0 small">Return shipping is free for defective items. For other returns, shipping costs may be deducted from your refund.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

.accordion-button:not(.collapsed) {
    background-color: #f8f9fa;
    color: #0d6efd;
}

.sticky-top {
    position: sticky;
    z-index: 100;
}

.display-6 {
    font-size: 2.5rem;
}

.btn {
    border-radius: 8px;
    padding: 0.5rem 1.25rem;
}

.modal-content {
    border-radius: 12px;
    border: none;
}

.modal-header {
    padding: 1.5rem 1.5rem 0.5rem;
}

.modal-body {
    padding: 1rem 1.5rem;
}

.modal-footer {
    padding: 1rem 1.5rem;
}

@media (max-width: 768px) {
    .display-6 {
        font-size: 2rem;
    }
    
    .sticky-top {
        position: static;
    }
}
</style>
@endsection