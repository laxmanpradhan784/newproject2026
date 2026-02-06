@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
    <!-- Hero Section -->
    <section class="contact-hero position-relative overflow-hidden py-5 py-lg-6">
        <div class="container pt-5 pt-lg-6">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0 animate-fade-in">
                    <div class="hero-content">
                        <div class="hero-badges mb-4">
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill me-2">
                                <i class="fas fa-clock me-1"></i>24/7 Support
                            </span>
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill me-2">
                                <i class="fas fa-bolt me-1"></i>Quick Response
                            </span>
                            <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">
                                <i class="fas fa-headset me-1"></i>Help Center
                            </span>
                        </div>

                        <h1 class="display-3 fw-bold mb-4 hero-title">Get In Touch</h1>
                        <p class="lead mb-4 hero-description">
                            Have questions? We're here to help! Reach out to us through any of the channels below or fill
                            out our contact form.
                        </p>

                        <!-- Quick Stats -->
                        <div class="quick-stats row g-3 mb-5">
                            <div class="col-4">
                                <div class="stat-item text-center">
                                    <div class="stat-icon mb-2">
                                        <i class="fas fa-check-circle fa-2x text-success"></i>
                                    </div>
                                    <div class="stat-text">
                                        <div class="stat-number fw-bold">99%</div>
                                        <div class="stat-label small text-muted">Satisfaction</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item text-center">
                                    <div class="stat-icon mb-2">
                                        <i class="fas fa-clock fa-2x text-primary"></i>
                                    </div>
                                    <div class="stat-text">
                                        <div class="stat-number fw-bold">2h</div>
                                        <div class="stat-label small text-muted">Avg. Response</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item text-center">
                                    <div class="stat-icon mb-2">
                                        <i class="fas fa-users fa-2x text-warning"></i>
                                    </div>
                                    <div class="stat-text">
                                        <div class="stat-number fw-bold">50+</div>
                                        <div class="stat-label small text-muted">Agents</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="hero-actions d-flex flex-wrap gap-3">
                            <a href="#contactForm" class="btn btn-primary btn-lg px-5 py-3 rounded-pill contact-now-btn">
                                <i class="fas fa-paper-plane me-2"></i>Contact Now
                            </a>
                            <a href="#faqAccordion" class="btn btn-outline-primary btn-lg px-5 py-3 rounded-pill">
                                <i class="fas fa-question-circle me-2"></i>View FAQ
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 animate-fade-in" style="animation-delay: 0.2s">
                    <div class="hero-image-wrapper position-relative">
                        <div class="hero-image rounded-4 overflow-hidden shadow-lg">
                            <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
                                alt="Contact Us" class="img-fluid w-100" loading="lazy" />
                        </div>
                        <!-- Floating Contact Elements -->
                        <div class="floating-contact floating-email position-absolute animate-float"
                            style="animation-delay: 0s">
                            <div class="floating-card rounded-3 bg-white shadow-lg p-3">
                                <i class="fas fa-envelope text-primary fa-2x mb-2"></i>
                                <div class="floating-text small fw-bold">Email Support</div>
                            </div>
                        </div>
                        <div class="floating-contact floating-phone position-absolute animate-float"
                            style="animation-delay: 1s">
                            <div class="floating-card rounded-3 bg-primary shadow-lg p-3 text-white">
                                <i class="fas fa-phone-alt fa-2x mb-2"></i>
                                <div class="floating-text small fw-bold">Call Us</div>
                            </div>
                        </div>
                        <div class="floating-contact floating-chat position-absolute animate-float"
                            style="animation-delay: 2s">
                            <div class="floating-card rounded-3 bg-success shadow-lg p-3 text-white">
                                <i class="fas fa-comment-dots fa-2x mb-2"></i>
                                <div class="floating-text small fw-bold">Live Chat</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Background Elements -->
        <div class="hero-bg-elements">
            <div class="bg-element-1"></div>
            <div class="bg-element-2"></div>
            <div class="bg-element-3"></div>
        </div>
    </section>

    <!-- Contact Information -->
    <section class="contact-info py-5 py-lg-6">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2 class="display-4 fw-bold mb-3">Contact Information</h2>
                <p class="lead text-muted mb-4">Multiple ways to reach us</p>
                <div class="section-divider mx-auto"></div>
            </div>

            <div class="row g-4 justify-content-center">
                @php
                    $site = \App\Models\SiteSetting::first();

                    // Address info
                    $address = $site->address ?? "123 Commerce Street\nSan Francisco, CA 94107\nUnited States";
                    $mapLink = $site->map_location ?? 'https://maps.google.com/?q=' . urlencode($address);

                    // Phone info
                    $phone1 = $site->phone_1 ?? '+1 (555) 123-4567';
                    $phone2 = $site->phone_2 ?? '+1 (555) 987-6543';

                    // Email info
                    $supportEmail = $site->email_support ?? 'support@eshop.com';
                    $businessEmail = $site->email_business ?? 'business@eshop.com';
                @endphp

                <!-- Address Card -->
                <div class="col-xl-4 col-lg-6">
                    <div class="contact-card p-4 h-100 hover-lift animate-fade-in">
                        <div class="contact-icon-wrapper mb-4">
                            <div class="contact-icon rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center mx-auto"
                                style="width: 90px; height: 90px;">
                                <i class="fas fa-map-marker-alt fa-3x text-primary"></i>
                            </div>
                        </div>
                        <h4 class="fw-bold mb-3 text-center">Visit Us</h4>
                        <p class="text-muted mb-4 text-center" style="white-space: pre-line;">{{ $address }}</p>
                        <div class="text-center">
                            <a href="{{ $mapLink }}" target="_blank" class="btn btn-outline-primary px-4">
                                <i class="fas fa-directions me-2"></i>Get Directions
                            </a>
                        </div>
                        <!-- Actual Map Preview -->
                        <div class="map-preview mt-4 rounded-3 overflow-hidden" style="height: 150px; background: #f8f9fa;">
                            @php
                                $site = \App\Models\SiteSetting::first();
                                $defaultMap =
                                    'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3721.240088208355!2d72.8044065!3d21.142841600000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04e4b45d3ca2b%3A0xaf9ae5ffda2095d3!2sWebmasters%20InfoTech!5e0!3m2!1sen!2sin!4v1737200381429!5m2!1sen!2sin';
                                $mapEmbed = $site->map_location ?? $defaultMap;
                            @endphp

                            <iframe frameborder="0" class="w-100 h-100" src="{{ $mapEmbed }}" style="border:0;"
                                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                                title="Our Location on Google Maps">
                            </iframe>
                        </div>
                    </div>
                </div>

                <!-- Phone Card -->
                <div class="col-xl-4 col-lg-6">
                    <div class="contact-card p-4 h-100 hover-lift animate-fade-in" style="animation-delay: 0.1s">
                        <div class="contact-icon-wrapper mb-4">
                            <div class="contact-icon rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center mx-auto"
                                style="width: 90px; height: 90px;">
                                <i class="fas fa-phone-alt fa-3x text-success"></i>
                            </div>
                        </div>
                        <h4 class="fw-bold mb-3 text-center">Call Us</h4>
                        <p class="text-muted mb-2 text-center">Available Monday to Friday, 9AM to 6PM</p>
                        <div class="phone-numbers text-center mb-4">
                            <div class="phone-primary mb-2">
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone1) }}"
                                    class="h5 text-primary fw-bold d-block">
                                    <i class="fas fa-phone me-2"></i>{{ $phone1 }}
                                </a>
                                <small class="text-muted">Primary Number</small>
                            </div>
                            @if ($phone2)
                                <div class="phone-secondary">
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone2) }}" class="text-dark d-block">
                                        <i class="fas fa-phone me-2"></i>{{ $phone2 }}
                                    </a>
                                    <small class="text-muted">Secondary Number</small>
                                </div>
                            @endif
                        </div>
                        <div class="text-center">
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone1) }}" class="btn btn-success px-4">
                                <i class="fas fa-phone-alt me-2"></i> Call Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Email Card -->
                <div class="col-xl-4 col-lg-6">
                    <div class="contact-card p-4 h-100 hover-lift animate-fade-in" style="animation-delay: 0.2s">
                        <div class="contact-icon-wrapper mb-4">
                            <div class="contact-icon rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center mx-auto"
                                style="width: 90px; height: 90px;">
                                <i class="fas fa-envelope fa-3x text-info"></i>
                            </div>
                        </div>
                        <h4 class="fw-bold mb-3 text-center">Email Us</h4>
                        <p class="text-muted mb-2 text-center">We typically respond within 24 hours</p>
                        <div class="email-addresses text-center mb-4">
                            <div class="email-support mb-3">
                                <a href="mailto:{{ $supportEmail }}" class="h5 text-info fw-bold d-block">
                                    <i class="fas fa-envelope me-2"></i>{{ $supportEmail }}
                                </a>
                                <small class="text-muted">Customer Support</small>
                            </div>
                            @if ($businessEmail)
                                <div class="email-business">
                                    <a href="mailto:{{ $businessEmail }}" class="text-dark d-block">
                                        <i class="fas fa-briefcase me-2"></i>{{ $businessEmail }}
                                    </a>
                                    <small class="text-muted">Business Inquiries</small>
                                </div>
                            @endif
                        </div>
                        <div class="text-center">
                            <a href="mailto:{{ $supportEmail }}" class="btn btn-info px-4">
                                <i class="fas fa-envelope me-2"></i> Send Email
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form -->
    <section id="contactForm" class="contact-form py-5 py-lg-6">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                        <div class="card-header bg-primary text-white py-4 px-5">
                            <div class="d-flex align-items-center">
                                <div class="form-icon me-3">
                                    <i class="fas fa-paper-plane fa-2x"></i>
                                </div>
                                <div>
                                    <h3 class="fw-bold mb-1">Send Us a Message</h3>
                                    <p class="mb-0 opacity-90">Fill out the form below and we'll get back to you as soon as
                                        possible</p>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-5">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                                    <div class="d-flex">
                                        <div class="alert-icon me-3">
                                            <i class="fas fa-exclamation-circle fa-lg"></i>
                                        </div>
                                        <div>
                                            <h5 class="alert-heading mb-2">Please fix the following errors:</h5>
                                            <ul class="mb-0 ps-3">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                                    <div class="d-flex">
                                        <div class="alert-icon me-3">
                                            <i class="fas fa-check-circle fa-lg"></i>
                                        </div>
                                        <div>
                                            <h5 class="alert-heading mb-2">Message Sent Successfully!</h5>
                                            <p class="mb-0">{{ session('success') }}</p>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('contact.submit') }}" method="POST" id="contactForm">
                                @csrf

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="form-label fw-bold mb-2">
                                                <i class="fas fa-user me-2 text-primary"></i>Full Name *
                                            </label>
                                            <div class="input-group input-group-lg">
                                                <input type="text" id="name" name="name"
                                                    class="form-control rounded-3" placeholder="John Doe"
                                                    value="{{ old('name') }}" required>
                                            </div>
                                            <div class="form-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="form-label fw-bold mb-2">
                                                <i class="fas fa-envelope me-2 text-primary"></i>Email Address *
                                            </label>
                                            <div class="input-group input-group-lg">
                                                <input type="email" id="email" name="email"
                                                    class="form-control rounded-3" placeholder="john@example.com"
                                                    value="{{ old('email') }}" required>
                                            </div>
                                            <div class="form-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone" class="form-label fw-bold mb-2">
                                                <i class="fas fa-phone me-2 text-primary"></i>Phone Number
                                            </label>
                                            <div class="input-group input-group-lg">
                                                <input type="tel" id="phone" name="phone"
                                                    class="form-control rounded-3" placeholder="+1 (123) 456-7890"
                                                    value="{{ old('phone') }}">
                                            </div>
                                            <div class="form-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subject" class="form-label fw-bold mb-2">
                                                <i class="fas fa-tag me-2 text-primary"></i>Subject *
                                            </label>
                                            <div class="input-group input-group-lg">
                                                <select id="subject" name="subject" class="form-select rounded-3"
                                                    required>
                                                    <option value="">Select a subject</option>
                                                    <option value="General Inquiry"
                                                        {{ old('subject') == 'General Inquiry' ? 'selected' : '' }}>General
                                                        Inquiry</option>
                                                    <option value="Product Support"
                                                        {{ old('subject') == 'Product Support' ? 'selected' : '' }}>Product
                                                        Support</option>
                                                    <option value="Order Issues"
                                                        {{ old('subject') == 'Order Issues' ? 'selected' : '' }}>Order
                                                        Issues</option>
                                                    <option value="Shipping & Delivery"
                                                        {{ old('subject') == 'Shipping & Delivery' ? 'selected' : '' }}>
                                                        Shipping & Delivery</option>
                                                    <option value="Returns & Refunds"
                                                        {{ old('subject') == 'Returns & Refunds' ? 'selected' : '' }}>
                                                        Returns & Refunds</option>
                                                    <option value="Business Partnership"
                                                        {{ old('subject') == 'Business Partnership' ? 'selected' : '' }}>
                                                        Business Partnership</option>
                                                    <option value="Feedback"
                                                        {{ old('subject') == 'Feedback' ? 'selected' : '' }}>Feedback
                                                    </option>
                                                    <option value="Other"
                                                        {{ old('subject') == 'Other' ? 'selected' : '' }}>Other</option>
                                                </select>
                                            </div>
                                            <div class="form-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="message" class="form-label fw-bold mb-2">
                                                <i class="fas fa-comment-dots me-2 text-primary"></i>Your Message *
                                            </label>
                                            <div class="input-group">
                                                <textarea id="message" name="message" class="form-control rounded-3" rows="6"
                                                    placeholder="How can we help you?" required>{{ old('message') }}</textarea>
                                            </div>
                                            <div class="d-flex justify-content-between mt-2">
                                                <div class="form-text">Maximum 1000 characters</div>
                                                <div class="char-counter text-muted small">
                                                    <span id="charCount">0</span>/1000 characters
                                                </div>
                                            </div>
                                            <div class="form-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="newsletter"
                                                name="newsletter" checked>
                                            <label class="form-check-label" for="newsletter">
                                                Subscribe to our newsletter for updates and offers
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="text-center pt-3">
                                            <button type="submit"
                                                class="btn btn-primary btn-lg px-5 py-3 rounded-pill submit-btn">
                                                <i class="fas fa-paper-plane me-2"></i> Send Message
                                            </button>
                                            <p class="text-muted small mt-3 mb-0">
                                                <i class="fas fa-lock me-1"></i>Your information is secure and will never
                                                be shared
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faqAccordion" class="faq py-5 py-lg-6">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2 class="display-4 fw-bold mb-3">Frequently Asked Questions</h2>
                <p class="lead text-muted mb-4">Quick answers to common questions</p>
                <div class="section-divider mx-auto"></div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">
                    <div class="accordion accordion-flush" id="faqAccordion">
                        @php
                            $faqs = [
                                [
                                    'question' => 'How long does shipping take?',
                                    'answer' =>
                                        'Standard shipping typically takes 5-7 business days. Express shipping (2-3 business days) is also available at checkout. International shipping may take 10-15 business days depending on the destination.',
                                    'icon' => 'shipping-fast',
                                ],
                                [
                                    'question' => 'What is your return policy?',
                                    'answer' =>
                                        'We offer a 30-day return policy for most items. Products must be in original condition with all tags and packaging. Some items like electronics have a 14-day return window. Return shipping is free for defective items.',
                                    'icon' => 'exchange-alt',
                                ],
                                [
                                    'question' => 'Do you ship internationally?',
                                    'answer' =>
                                        'Yes, we ship to over 100 countries worldwide. International shipping costs and delivery times vary by location. You can see the exact shipping cost at checkout before completing your purchase.',
                                    'icon' => 'globe',
                                ],
                                [
                                    'question' => 'How can I track my order?',
                                    'answer' =>
                                        'Once your order ships, you\'ll receive a tracking number via email. You can also log into your account and check the "My Orders" section for real-time tracking information.',
                                    'icon' => 'map-marked-alt',
                                ],
                                [
                                    'question' => 'What payment methods do you accept?',
                                    'answer' =>
                                        'We accept all major credit cards (Visa, MasterCard, American Express), PayPal, Apple Pay, Google Pay, and bank transfers. All payments are processed securely through encrypted connections.',
                                    'icon' => 'credit-card',
                                ],
                                [
                                    'question' => 'How can I contact customer support?',
                                    'answer' =>
                                        'You can contact us via phone, email, or live chat. Our support team is available 24/7 for urgent matters. For non-urgent inquiries, email support typically responds within 24 hours.',
                                    'icon' => 'headset',
                                ],
                            ];
                        @endphp

                        @foreach ($faqs as $index => $faq)
                            <div class="accordion-item border rounded-3 mb-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-bold py-4" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#faq{{ $index + 1 }}"
                                        aria-expanded="false" aria-controls="faq{{ $index + 1 }}">
                                        <div class="d-flex align-items-center w-100">
                                            <div class="faq-icon me-3">
                                                <i class="fas fa-{{ $faq['icon'] }} text-primary"></i>
                                            </div>
                                            <span class="faq-question">{{ $faq['question'] }}</span>
                                            <span class="ms-auto">
                                                <i class="fas fa-chevron-down accordion-arrow"></i>
                                            </span>
                                        </div>
                                    </button>
                                </h2>
                                <div id="faq{{ $index + 1 }}" class="accordion-collapse collapse"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body py-4">
                                        <div class="faq-answer">
                                            <p class="mb-0">{{ $faq['answer'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-center mt-5 pt-3">
                        <p class="lead mb-4">Still have questions?</p>
                        <div class="d-flex flex-wrap justify-content-center gap-3">
                            <a href="#contactForm" class="btn btn-primary px-4">
                                <i class="fas fa-paper-plane me-2"></i>Send us a message
                            </a>
                            <a href="#" class="btn btn-outline-primary px-4">
                                <i class="fas fa-question-circle me-2"></i>Visit Help Center
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Live Chat Widget (Placeholder) -->
    <div class="live-chat-widget position-fixed bottom-4 end-4 z-3 d-none d-lg-block">
        <div class="chat-toggle-btn rounded-circle shadow-lg bg-primary text-white d-flex align-items-center justify-content-center"
            style="width: 60px; height: 60px; cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="left"
            title="Live Chat Support">
            <i class="fas fa-comment-dots fa-lg"></i>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        :root {
            --primary-color: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: rgba(99, 102, 241, 0.1);
            --secondary-color: #ec4899;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #3b82f6;
            --light-color: #f8fafc;
            --dark-color: #1e293b;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
            opacity: 0;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-pulse {
            animation: pulse 2s ease-in-out infinite;
        }

        /* Hero Section */
        .contact-hero {
            background: linear-gradient(135deg, #f0f4ff 0%, #e6f0ff 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-description {
            font-size: 1.2rem;
            line-height: 1.7;
            max-width: 600px;
        }

        .hero-badges .badge {
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .hero-badges .badge:hover {
            transform: translateY(-2px);
        }

        .quick-stats .stat-item {
            padding: 15px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .quick-stats .stat-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-number {
            font-size: 1.5rem;
        }

        .hero-image-wrapper {
            position: relative;
        }

        .hero-image {
            transform: perspective(1000px) rotateY(-5deg);
            transition: transform 0.5s ease;
        }

        .hero-image:hover {
            transform: perspective(1000px) rotateY(0);
        }

        .floating-contact {
            z-index: 2;
        }

        .floating-email {
            top: 20%;
            left: -30px;
            animation-delay: 0s;
        }

        .floating-phone {
            bottom: 30%;
            right: -30px;
            animation-delay: 1s;
        }

        .floating-chat {
            top: 10%;
            right: 15%;
            animation-delay: 2s;
        }

        .floating-card {
            width: 100px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .floating-card:hover {
            transform: scale(1.1);
        }

        /* Background Elements */
        .hero-bg-elements {
            position: absolute;
            inset: 0;
            overflow: hidden;
            z-index: 1;
        }

        .bg-element-1,
        .bg-element-2,
        .bg-element-3 {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
        }

        .bg-element-1 {
            width: 300px;
            height: 300px;
            background: var(--primary-color);
            top: -150px;
            right: -150px;
        }

        .bg-element-2 {
            width: 200px;
            height: 200px;
            background: var(--secondary-color);
            bottom: -100px;
            left: -100px;
        }

        .bg-element-3 {
            width: 150px;
            height: 150px;
            background: var(--success-color);
            top: 50%;
            left: 10%;
        }

        /* Contact Cards */
        .contact-card {
            background: white;
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 20px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .contact-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important;
        }

        .contact-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .contact-card:hover::before {
            opacity: 1;
        }

        .contact-icon-wrapper {
            position: relative;
        }

        .contact-icon {
            transition: all 0.3s ease;
        }

        .contact-card:hover .contact-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .phone-primary a,
        .email-support a {
            transition: all 0.3s ease;
        }

        .phone-primary a:hover,
        .email-support a:hover {
            color: var(--primary-dark) !important;
            text-decoration: none;
        }

        /* Map Preview */
        .map-preview {
            position: relative;
            overflow: hidden;
        }

        .map-preview i {
            transition: all 0.3s ease;
        }

        .contact-card:hover .map-preview i {
            transform: scale(1.2);
        }

        /* Contact Form */
        .contact-form .card {
            border-radius: 24px;
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        }

        .form-icon {
            opacity: 0.9;
        }

        .form-group {
            position: relative;
        }

        .form-label {
            display: flex;
            align-items: center;
            color: var(--dark-color);
        }

        .form-control,
        .form-select {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(243, 243, 245, 0.1);
            outline: none;
        }

        .form-control.error,
        .form-select.error {
            border-color: var(--danger-color);
        }

        .form-control.valid,
        .form-select.valid {
            border-color: var(--success-color);
        }

        .form-feedback {
            font-size: 0.875rem;
            margin-top: 4px;
            min-height: 20px;
        }

        .form-feedback.error {
            color: var(--danger-color);
        }

        .form-feedback.valid {
            color: var(--success-color);
        }

        .char-counter {
            font-weight: 500;
        }

        #charCount.warning {
            color: var(--warning-color);
        }

        #charCount.danger {
            color: var(--danger-color);
        }

        .submit-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
        }

        .submit-btn.loading {
            padding-right: 50px;
        }

        .submit-btn.loading::after {
            content: '';
            position: absolute;
            right: 20px;
            top: 50%;
            width: 20px;
            height: 20px;
            margin-top: -10px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* FAQ Section */
        .accordion-item {
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .accordion-item:hover {
            border-color: var(--primary-color);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .accordion-button {
            background: white;
            color: var(--dark-color);
            font-size: 1.1rem;
            padding: 20px;
            border: none;
        }

        .accordion-button:not(.collapsed) {
            background: var(--primary-light);
            color: var(--primary-color);
            box-shadow: none;
        }

        .accordion-button:focus {
            box-shadow: none;
            border-color: var(--primary-color);
        }

        .accordion-button::after {
            display: none;
        }

        .accordion-arrow {
            transition: transform 0.3s ease;
        }

        .accordion-button:not(.collapsed) .accordion-arrow {
            transform: rotate(180deg);
        }

        .faq-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-light);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .faq-question {
            flex: 1;
        }

        .accordion-body {
            background: var(--light-color);
            border-top: 1px solid #e2e8f0;
        }

        /* Live Chat Widget */
        .live-chat-widget {
            z-index: 1000;
        }

        .chat-toggle-btn {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .chat-toggle-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
        }

        /* Section Styling */
        .section-header {
            position: relative;
        }

        .section-divider {
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 2px;
        }

        /* Hover Lift Effect */
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .floating-card {
                width: 80px;
                padding: 15px !important;
            }

            .floating-card i {
                font-size: 1.5rem !important;
            }

            .contact-card {
                margin-bottom: 30px;
            }

            .display-4 {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }

            .hero-description {
                font-size: 1.1rem;
            }

            .hero-actions .btn {
                width: 100%;
                margin-bottom: 10px;
            }

            .floating-contact {
                display: none;
            }

            .card-body {
                padding: 2rem !important;
            }

            .form-control,
            .form-select {
                padding: 10px 14px;
            }
        }

        @media (max-width: 576px) {
            .hero-title {
                font-size: 1.75rem;
            }

            .hero-badges .badge {
                display: block;
                margin-bottom: 10px;
                margin-right: 0 !important;
            }

            .quick-stats .col-4 {
                margin-bottom: 15px;
            }

            .contact-card {
                padding: 2rem !important;
            }

            .accordion-button {
                font-size: 1rem;
                padding: 15px;
            }

            .faq-icon {
                width: 30px;
                height: 30px;
                font-size: 0.9rem;
            }
        }

        /* Dark Mode Support */
        @media (prefers-color-scheme: dark) {
            .contact-hero {
                background: linear-gradient(135deg, #f4f5f7 0%, #1e293b 100%);
            }

            .contact-card,
            .quick-stats .stat-item,
            .accordion-item,
            .accordion-button {
                background: #d4d7db;
                border-color: #d2d7dd;
                color: #5889c9;
            }

            .text-muted {
                color: #94a3b8 !important;
            }

            .form-control,
            .form-select {
                background: #717780;
                border-color: #475569;
                color: #e2e8f0;
            }

            .form-control:focus,
            .form-select:focus {
                background: #79a0df;
                border-color: var(--primary-color);
            }

            .accordion-body {
                background: #1e293b;
            }
        }

        /* Accessibility */
        :focus-visible {
            outline: 3px solid var(--primary-color);
            outline-offset: 3px;
            border-radius: 4px;
        }

        /* Touch Device Optimizations */
        @media (hover: none) and (pointer: coarse) {
            .hover-lift:hover {
                transform: none;
            }

            .hero-image:hover {
                transform: perspective(1000px) rotateY(-5deg);
            }

            .floating-card:hover {
                transform: none;
            }

            .submit-btn:hover {
                transform: none;
            }

            .chat-toggle-btn:hover {
                transform: none;
            }

            /* Increase touch targets */
            .btn,
            .form-control,
            .form-select,
            .accordion-button {
                min-height: 44px;
            }

            .social-link {
                min-width: 44px;
                min-height: 44px;
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

        function initFAQAccordion() {
            const accordionButtons = document.querySelectorAll('.accordion-button');

            accordionButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const isExpanded = this.getAttribute('aria-expanded') === 'true';

                    // Update arrow rotation
                    const arrow = this.querySelector('.accordion-arrow');
                    arrow.style.transform = isExpanded ? 'rotate(0deg)' : 'rotate(180deg)';
                });
            });
        }

        function initLiveChatWidget() {
            const chatToggle = document.querySelector('.chat-toggle-btn');

            if (chatToggle) {
                // Initialize Bootstrap tooltip
                new bootstrap.Tooltip(chatToggle);

                chatToggle.addEventListener('click', function() {
                    showToast('Live chat feature coming soon!', 'info');
                    // In a real application, you would open a chat widget here
                });
            }
        }

        function initCharCounter() {
            const messageField = document.getElementById('message');
            const charCount = document.getElementById('charCount');

            if (messageField && charCount) {
                messageField.addEventListener('input', function() {
                    const length = this.value.length;
                    charCount.textContent = length;

                    // Update color based on length
                    if (length > 900) {
                        charCount.classList.add('danger');
                        charCount.classList.remove('warning');
                    } else if (length > 800) {
                        charCount.classList.add('warning');
                        charCount.classList.remove('danger');
                    } else {
                        charCount.classList.remove('warning', 'danger');
                    }

                    // Truncate if exceeds limit
                    if (length > 1000) {
                        this.value = this.value.substring(0, 1000);
                        charCount.textContent = 1000;
                        charCount.classList.add('danger');
                    }
                });

                // Initial count
                charCount.textContent = messageField.value.length;
            }
        }

        function resetCharCounter() {
            const charCount = document.getElementById('charCount');
            if (charCount) {
                charCount.textContent = '0';
                charCount.classList.remove('warning', 'danger');
            }
        }

        function initPhoneFormatting() {
            const phoneField = document.getElementById('phone');

            if (phoneField) {
                phoneField.addEventListener('input', function(e) {
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

                    this.value = value;
                });
            }
        }

        function initSmoothScrolling() {
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    if (href !== '#') {
                        e.preventDefault();
                        const target = document.querySelector(href);
                        if (target) {
                            const headerOffset = 100;
                            const elementPosition = target.getBoundingClientRect().top;
                            const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                            window.scrollTo({
                                top: offsetPosition,
                                behavior: 'smooth'
                            });
                        }
                    }
                });
            });
        }

        // Toast notification function
        function showToast(message, type = 'info') {
            const toastContainer = document.getElementById('toastContainer') || createToastContainer();

            const toast = document.createElement('div');
            toast.className =
                `toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'error' ? 'danger' : type === 'warning' ? 'warning' : 'info'} border-0`;
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');

            const icon = type === 'success' ? 'check-circle' :
                type === 'error' ? 'exclamation-circle' :
                type === 'warning' ? 'exclamation-triangle' : 'info-circle';

            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-${icon} me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            `;

            toastContainer.appendChild(toast);

            const bsToast = new bootstrap.Toast(toast, {
                autohide: true,
                delay: 3000
            });

            bsToast.show();

            toast.addEventListener('hidden.bs.toast', () => {
                toast.remove();
            });
        }

        function createToastContainer() {
            const container = document.createElement('div');
            container.id = 'toastContainer';
            container.className = 'toast-container position-fixed';
            container.style.cssText =
                'z-index: 99999; bottom: 20px; right: 20px; left: 20px; max-width: 400px; margin-left: auto; margin-right: auto;';
            document.body.appendChild(container);
            return container;
        }

        // Auto-hide alerts after 5 seconds
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    </script>
@endpush
