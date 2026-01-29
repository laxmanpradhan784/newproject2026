@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
    <!-- Hero Section -->
    <section class="contact-hero py-5 bg-light">
        <div class="container pt-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Get In Touch</h1>
                    <p class="lead mb-4">Have questions? We're here to help! Reach out to us through any of the channels
                        below.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <span class="badge bg-primary p-3">24/7 Support</span>
                        <span class="badge bg-success p-3">Quick Response</span>
                        <span class="badge bg-info p-3">Help Center</span>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                        alt="Contact Us" class="img-fluid rounded-3 shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Information -->
    <section class="contact-info py-5">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2>Contact Information</h2>
                <p class="text-muted">Multiple ways to reach us</p>
            </div>

            <div class="row g-4">
                @php
                    $site = \App\Models\SiteSetting::first();
                    $address = $site->address ?? "123 Commerce Street\nSan Francisco, CA 94107\nUnited States";
                    $mapLink = $site->map_location ?? 'https://maps.google.com/?q=' . urlencode($address);
                @endphp

                <div class="col-md-4">
                    <div class="contact-card text-center p-4 h-100">
                        <div class="contact-icon mb-4">
                            <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                            </div>
                        </div>
                        <h4 class="fw-bold mb-3">Visit Us</h4>
                        <p class="text-muted mb-0" style="white-space: pre-line;">{{ $address }}</p>
                        <a href="#" target="_blank" class="btn btn-link text-primary mt-3">
                            Get Directions <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>

                @php
                    $site = \App\Models\SiteSetting::first();
                    $phone1 = $site->phone_1 ?? '+1 (555) 123-4567';
                    $phone2 = $site->phone_2 ?? '+1 (555) 987-6543';
                @endphp

                <div class="col-md-4">
                    <div class="contact-card text-center p-4 h-100">
                        <div class="contact-icon mb-4">
                            <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-phone fa-2x text-primary"></i>
                            </div>
                        </div>
                        <h4 class="fw-bold mb-3">Call Us</h4>
                        <p class="text-muted mb-2">Available Monday to Friday, 9AM to 6PM</p>
                        <h5 class="text-primary"> Primary Number:- {{ $phone1 }}</h5>
                        @if ($phone2)
                            <p class="text-muted small mt-2"> {{ $phone2 }}</p>
                        @endif
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone1) }}" class="btn btn-primary mt-3">
                            <i class="fas fa-phone-alt me-2"></i> Call Now
                        </a>
                    </div>
                </div>

                @php
                    $site = \App\Models\SiteSetting::first();
                    $supportEmail = $site->email_support ?? 'support@eshop.com';
                    $businessEmail = $site->email_business ?? 'business@eshop.com';
                @endphp

                <div class="col-md-4">
                    <div class="contact-card text-center p-4 h-100">
                        <div class="contact-icon mb-4">
                            <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-envelope fa-2x text-primary"></i>
                            </div>
                        </div>
                        <h4 class="fw-bold mb-3">Email Us</h4>
                        <p class="text-muted mb-2">We typically respond within 24 hours</p>
                        <h5 class="text-primary">{{ $supportEmail }}</h5>
                        @if ($businessEmail)
                            <p class="text-muted small mt-2">For business: {{ $businessEmail }}</p>
                        @endif
                        <a href="mailto:{{ $supportEmail }}" class="btn btn-primary mt-3">
                            <i class="fas fa-envelope me-2"></i> Send Email
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form -->
    <section class="contact-form py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-5">
                            <div class="section-title text-center mb-4">
                                <h2>Send Us a Message</h2>
                                <p class="text-muted">Fill out the form below and we'll get back to you as soon as possible
                                </p>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    Please fix the following errors:
                                    <ul class="mt-2 mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('contact.submit') }}" method="POST" id="contactForm">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="name" class="form-label fw-bold">Full Name *</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" id="name" name="name" class="form-control"
                                                placeholder="John Doe" value="{{ old('name') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label for="email" class="form-label fw-bold">Email Address *</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="email" id="email" name="email" class="form-control"
                                                placeholder="john@example.com" value="{{ old('email') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="phone" class="form-label fw-bold">Phone Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            <input type="tel" id="phone" name="phone" class="form-control"
                                                placeholder="+1 (123) 456-7890" value="{{ old('phone') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label for="subject" class="form-label fw-bold">Subject *</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                            <select id="subject" name="subject" class="form-select" required>
                                                <option value="">Select a subject</option>
                                                <option value="General Inquiry"
                                                    {{ old('subject') == 'General Inquiry' ? 'selected' : '' }}>General
                                                    Inquiry</option>
                                                <option value="Product Support"
                                                    {{ old('subject') == 'Product Support' ? 'selected' : '' }}>Product
                                                    Support</option>
                                                <option value="Order Issues"
                                                    {{ old('subject') == 'Order Issues' ? 'selected' : '' }}>Order Issues
                                                </option>
                                                <option value="Shipping & Delivery"
                                                    {{ old('subject') == 'Shipping & Delivery' ? 'selected' : '' }}>
                                                    Shipping & Delivery</option>
                                                <option value="Returns & Refunds"
                                                    {{ old('subject') == 'Returns & Refunds' ? 'selected' : '' }}>Returns &
                                                    Refunds</option>
                                                <option value="Business Partnership"
                                                    {{ old('subject') == 'Business Partnership' ? 'selected' : '' }}>
                                                    Business Partnership</option>
                                                <option value="Feedback"
                                                    {{ old('subject') == 'Feedback' ? 'selected' : '' }}>Feedback</option>
                                                <option value="Other" {{ old('subject') == 'Other' ? 'selected' : '' }}>
                                                    Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="message" class="form-label fw-bold">Your Message *</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-comment-dots"></i></span>
                                        <textarea id="message" name="message" class="form-control" rows="6" placeholder="How can we help you?"
                                            required>{{ old('message') }}</textarea>
                                    </div>
                                    <div class="form-text">Maximum 1000 characters</div>
                                </div>

                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="newsletter"
                                            name="newsletter" checked>
                                        <label class="form-check-label" for="newsletter">
                                            Subscribe to our newsletter for updates and offers
                                        </label>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-lg px-5" id="submitBtn">
                                        <i class="fas fa-paper-plane me-2"></i> Send Message
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq py-5">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2>Frequently Asked Questions</h2>
                <p class="text-muted">Quick answers to common questions</p>
            </div>

            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#faq1">
                                    How long does shipping take?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Standard shipping typically takes 5-7 business days. Express shipping (2-3 business
                                    days) is also available at checkout. International shipping may take 10-15 business days
                                    depending on the destination.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#faq2">
                                    What is your return policy?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    We offer a 30-day return policy for most items. Products must be in original condition
                                    with all tags and packaging. Some items like electronics have a 14-day return window.
                                    Return shipping is free for defective items.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Do you ship internationally?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes, we ship to over 100 countries worldwide. International shipping costs and delivery
                                    times vary by location. You can see the exact shipping cost at checkout before
                                    completing your purchase.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#faq4">
                                    How can I track my order?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Once your order ships, you'll receive a tracking number via email. You can also log into
                                    your account and check the "My Orders" section for real-time tracking information.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#faq5">
                                    What payment methods do you accept?
                                </button>
                            </h2>
                            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    We accept all major credit cards (Visa, MasterCard, American Express), PayPal, Apple
                                    Pay, Google Pay, and bank transfers. All payments are processed securely through
                                    encrypted connections.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-5">
                        <p class="mb-0">
                            Still have questions? <a href="#contactForm" class="text-primary fw-bold">Send us a
                                message</a> or check our <a href="#" class="text-primary fw-bold">Help Center</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section py-5 bg-light">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2>Find Our Office</h2>
                <p class="text-muted">Visit us at our headquarters</p>
            </div>

            <!-- Map Section -->
            <section class="map-section">
                @php
                    $site = \App\Models\SiteSetting::first();

                    // Default coordinates if not set (you can change these)
                    $defaultMap =
                        'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3721.240088208355!2d72.8044065!3d21.142841600000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04e4b45d3ca2b%3A0xaf9ae5ffda2095d3!2sWebmasters%20InfoTech!5e0!3m2!1sen!2sin!4v1737200381429!5m2!1sen!2sin';

                    // Use stored map_location or default
                    $mapEmbed = $site->map_location ?? $defaultMap;
                @endphp

                <iframe frameborder="0" class="w-100 h-100" src="{{ $mapEmbed }}" width="600" height="450"
                    style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </section>
            <!-- End Map Section -->

            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="text-center p-4">
                        <div class="icon-wrapper mb-3">
                            <i class="fas fa-clock fa-2x text-primary"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Business Hours</h5>
                        <ul class="list-unstyled text-muted">
                            <li class="mb-2">Monday - Friday: 9:00 AM - 6:00 PM</li>
                            <li class="mb-2">Saturday: 10:00 AM - 4:00 PM</li>
                            <li>Sunday: Closed</li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="text-center p-4">
                        <div class="icon-wrapper mb-3">
                            <i class="fas fa-headset fa-2x text-primary"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Support Hours</h5>
                        <ul class="list-unstyled text-muted">
                            <li class="mb-2">Phone Support: 24/7</li>
                            <li class="mb-2">Email Support: 24/7</li>
                            <li>Live Chat: 8:00 AM - 10:00 PM EST</li>
                        </ul>
                        <p class="small text-muted">* Response time for email is within 24 hours</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="text-center p-4">
                        <div class="icon-wrapper mb-3">
                            <i class="fas fa-shield-alt fa-2x text-primary"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Security & Privacy</h5>
                        <p class="text-muted">Your information is secure with us. We never share your data with third
                            parties.</p>
                        <div class="d-flex justify-content-center gap-3 mt-3">
                            <span class="badge bg-dark">SSL Secure</span>
                            <span class="badge bg-dark">GDPR Compliant</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Media -->
    <section class="social-media py-5">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2>Connect With Us</h2>
                <p class="text-muted">Follow us on social media for updates and promotions</p>
            </div>

            @php
                $site = \App\Models\SiteSetting::first();
            @endphp

            <div class="row justify-content-center">
                <div class="col-auto">
                    <div class="social-icons d-flex flex-wrap justify-content-center gap-4">
                        @if ($site && $site->facebook)
                            <a href="{{ $site->facebook }}" target="_blank"
                                class="social-icon facebook rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fab fa-facebook-f fa-lg"></i>
                            </a>
                        @endif

                        @if ($site && $site->twitter)
                            <a href="{{ $site->twitter }}" target="_blank"
                                class="social-icon twitter rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fab fa-twitter fa-lg"></i>
                            </a>
                        @endif

                        @if ($site && $site->instagram)
                            <a href="{{ $site->instagram }}" target="_blank"
                                class="social-icon instagram rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fab fa-instagram fa-lg"></i>
                            </a>
                        @endif

                        @if ($site && $site->linkedin)
                            <a href="{{ $site->linkedin }}" target="_blank"
                                class="social-icon linkedin rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fab fa-linkedin-in fa-lg"></i>
                            </a>
                        @endif

                        @if ($site && $site->youtube)
                            <a href="{{ $site->youtube }}" target="_blank"
                                class="social-icon youtube rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fab fa-youtube fa-lg"></i>
                            </a>
                        @endif

                        @if ($site && $site->pinterest)
                            <a href="{{ $site->pinterest }}" target="_blank"
                                class="social-icon pinterest rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fab fa-pinterest-p fa-lg"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-dark: #3a56d4;
        }

        /* Hero Section */
        .contact-hero {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        /* Section Title */
        .section-title {
            text-align: center;
            margin-bottom: 60px;
            position: relative;
        }

        .section-title h2 {
            font-weight: 700;
            color: #333;
            display: inline-block;
            padding-bottom: 10px;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            width: 80px;
            height: 3px;
            background: var(--primary-color);
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        /* Contact Cards */
        .contact-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .contact-card:hover {
            transform: translateY(-10px);
            border-color: var(--primary-color);
            box-shadow: 0 15px 30px rgba(67, 97, 238, 0.15);
        }

        /* Contact Form */
        .contact-form .card {
            border-radius: 20px;
        }

        .contact-form .form-control,
        .contact-form .form-select {
            padding: 12px 15px;
            border: 2px solid #e1e5eb;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .contact-form .form-control:focus,
        .contact-form .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }

        .contact-form .input-group-text {
            background-color: #f8f9fa;
            border: 2px solid #e1e5eb;
            border-right: none;
        }

        /* FAQ Accordion */
        .accordion-button {
            background-color: white;
            border: 1px solid #e1e5eb;
            border-radius: 10px !important;
            padding: 1rem 1.5rem;
        }

        .accordion-button:not(.collapsed) {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
            box-shadow: none;
        }

        .accordion-button:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }

        .accordion-body {
            padding: 1.5rem;
            background-color: #f8f9fa;
            border-radius: 0 0 10px 10px;
        }

        /* Social Icons */
        .social-icon {
            width: 60px;
            height: 60px;
            color: white;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .social-icon.facebook {
            background-color: #3b5998;
        }

        .social-icon.twitter {
            background-color: #1da1f2;
        }

        .social-icon.instagram {
            background: linear-gradient(45deg, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d);
        }

        .social-icon.linkedin {
            background-color: #0077b5;
        }

        .social-icon.youtube {
            background-color: #ff0000;
        }

        .social-icon.pinterest {
            background-color: #bd081c;
        }

        .social-icon:hover {
            transform: translateY(-5px) scale(1.1);
            text-decoration: none;
        }

        /* Badges */
        .badge {
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: 20px;
        }

        /* Map Container */
        .map-container {
            border-radius: 15px;
            overflow: hidden;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .contact-hero h1 {
                font-size: 2.5rem;
            }

            .contact-card {
                margin-bottom: 20px;
            }

            .contact-form .card-body {
                padding: 2rem !important;
            }

            .social-icon {
                width: 50px;
                height: 50px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Form submission handling
            $('#contactForm').on('submit', function(e) {
                const submitBtn = $('#submitBtn');
                const originalText = submitBtn.html();

                // Show loading state
                submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i> Sending...');
                submitBtn.prop('disabled', true);

                // In a real application, you would have AJAX submission here
                // For demo purposes, we'll simulate a delay
                setTimeout(() => {
                    submitBtn.html(originalText);
                    submitBtn.prop('disabled', false);
                }, 2000);
            });

            // Character counter for message
            $('#message').on('input', function() {
                const maxLength = 1000;
                const currentLength = $(this).val().length;
                const counter = $(this).closest('.mb-4').find('.form-text');

                if (currentLength > maxLength) {
                    $(this).val($(this).val().substring(0, maxLength));
                    counter.html('<span class="text-danger">Maximum 1000 characters reached</span>');
                } else {
                    counter.html(`${maxLength - currentLength} characters remaining`);
                }
            });

            // Phone number formatting
            $('#phone').on('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');

                if (value.length > 0) {
                    if (value.length <= 3) {
                        value = '+' + value;
                    } else if (value.length <= 6) {
                        value = '+' + value.substring(0, 3) + ' (' + value.substring(3);
                    } else if (value.length <= 9) {
                        value = '+' + value.substring(0, 3) + ' (' + value.substring(3, 6) + ') ' + value
                            .substring(6);
                    } else {
                        value = '+' + value.substring(0, 3) + ' (' + value.substring(3, 6) + ') ' + value
                            .substring(6, 9) + '-' + value.substring(9, 13);
                    }
                }

                $(this).val(value);
            });

            // FAQ accordion animation
            $('.accordion-button').on('click', function() {
                $(this).toggleClass('collapsed');
            });

            // Smooth scroll to form
            $('a[href="#contactForm"]').on('click', function(e) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: $('#contactForm').offset().top - 100
                }, 800);
            });

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush
