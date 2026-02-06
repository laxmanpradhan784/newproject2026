@extends('layouts.app') 

@section('title', 'About Us') 

@section('content')
<!-- Hero Section -->
<section class="about-hero position-relative overflow-hidden py-5 py-lg-6">
    <div class="container pt-5 pt-lg-6">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0 animate-fade-in">
                <div class="hero-content">
                    <div class="hero-badge mb-4">
                        <span class="badge bg-primary bg-opacity-10 text-primary px-4 py-2 rounded-pill">
                            <i class="fas fa-rocket me-2"></i>Since 2010
                        </span>
                    </div>
                    <h1 class="display-3 fw-bold mb-4 hero-title">Our Story</h1>
                    <p class="lead mb-4 hero-description">
                        Founded in 2010, E-Shop has grown from a small startup to one of the
                        leading e-commerce platforms, serving millions of satisfied customers
                        worldwide.
                    </p>
                    
                    <!-- Stats -->
                    <div class="row g-3 stats-row">
                        <div class="col-4">
                            <div class="stat-card text-center p-3 rounded-3">
                                <div class="stat-number display-6 fw-bold text-primary mb-2">
                                    <span class="counter" data-count="10">0</span>M+
                                </div>
                                <p class="stat-label text-muted mb-0 small">Happy Customers</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-card text-center p-3 rounded-3">
                                <div class="stat-number display-6 fw-bold text-primary mb-2">
                                    <span class="counter" data-count="50">0</span>K+
                                </div>
                                <p class="stat-label text-muted mb-0 small">Products</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-card text-center p-3 rounded-3">
                                <div class="stat-number display-6 fw-bold text-primary mb-2">
                                    <span class="counter" data-count="100">0</span>+
                                </div>
                                <p class="stat-label text-muted mb-0 small">Countries</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- CTA Buttons -->
                    <div class="hero-actions mt-5">
                        <a href="#mission" class="btn btn-primary btn-lg px-5 py-3 rounded-pill me-3">
                            <i class="fas fa-arrow-down me-2"></i>Learn More
                        </a>
                        <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-lg px-5 py-3 rounded-pill">
                            <i class="fas fa-phone me-2"></i>Contact Us
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 animate-fade-in" style="animation-delay: 0.2s">
                <div class="hero-image-wrapper position-relative">
                    <div class="hero-image rounded-4 overflow-hidden shadow-lg">
                        <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
                            alt="About Us" class="img-fluid w-100"
                            loading="lazy" />
                    </div>
                    <!-- Floating Elements -->
                    <div class="floating-element floating-1 position-absolute">
                        <div class="floating-card rounded-circle bg-white shadow d-flex align-items-center justify-content-center">
                            <i class="fas fa-award text-primary fa-2x"></i>
                        </div>
                    </div>
                    <div class="floating-element floating-2 position-absolute">
                        <div class="floating-card rounded-circle bg-primary shadow d-flex align-items-center justify-content-center">
                            <i class="fas fa-shipping-fast text-white fa-2x"></i>
                        </div>
                    </div>
                    <div class="floating-element floating-3 position-absolute">
                        <div class="floating-card rounded-circle bg-warning shadow d-flex align-items-center justify-content-center">
                            <i class="fas fa-heart text-white fa-2x"></i>
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
    </div>
</section>

<!-- Mission & Vision -->
<section id="mission" class="mission-vision py-5 py-lg-6">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100 hover-lift mission-card animate-fade-in">
                    <div class="card-body p-4 p-lg-5">
                        <div class="mission-header d-flex align-items-center mb-4">
                            <div class="icon-wrapper me-4">
                                <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center"
                                    style="width: 70px; height: 70px">
                                    <i class="fas fa-bullseye fa-2x text-primary"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="fw-bold mb-2">Our Mission</h3>
                                <div class="mission-badge">
                                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1">
                                        What Drives Us
                                    </span>
                                </div>
                            </div>
                        </div>
                        <p class="mb-4 mission-description">
                            To provide customers with an exceptional online shopping
                            experience by offering high-quality products, competitive prices,
                            and unparalleled customer service.
                        </p>
                        <ul class="mission-list list-unstyled">
                            <li class="mb-3 d-flex align-items-start">
                                <div class="list-icon me-3">
                                    <i class="fas fa-check-circle text-primary fa-lg"></i>
                                </div>
                                <span>Quality products at best prices</span>
                            </li>
                            <li class="mb-3 d-flex align-items-start">
                                <div class="list-icon me-3">
                                    <i class="fas fa-check-circle text-primary fa-lg"></i>
                                </div>
                                <span>Fast and reliable delivery</span>
                            </li>
                            <li class="mb-3 d-flex align-items-start">
                                <div class="list-icon me-3">
                                    <i class="fas fa-check-circle text-primary fa-lg"></i>
                                </div>
                                <span>24/7 customer support</span>
                            </li>
                            <li class="d-flex align-items-start">
                                <div class="list-icon me-3">
                                    <i class="fas fa-check-circle text-primary fa-lg"></i>
                                </div>
                                <span>Secure shopping experience</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100 hover-lift vision-card animate-fade-in" style="animation-delay: 0.1s">
                    <div class="card-body p-4 p-lg-5">
                        <div class="vision-header d-flex align-items-center mb-4">
                            <div class="icon-wrapper me-4">
                                <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center"
                                    style="width: 70px; height: 70px">
                                    <i class="fas fa-eye fa-2x text-primary"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="fw-bold mb-2">Our Vision</h3>
                                <div class="vision-badge">
                                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1">
                                        Where We're Going
                                    </span>
                                </div>
                            </div>
                        </div>
                        <p class="mb-4 vision-description">
                            To become the world's most customer-centric e-commerce platform,
                            where people can discover and purchase anything they need online.
                        </p>
                        <ul class="vision-list list-unstyled">
                            <li class="mb-3 d-flex align-items-start">
                                <div class="list-icon me-3">
                                    <i class="fas fa-check-circle text-primary fa-lg"></i>
                                </div>
                                <span>Global e-commerce leader</span>
                            </li>
                            <li class="mb-3 d-flex align-items-start">
                                <div class="list-icon me-3">
                                    <i class="fas fa-check-circle text-primary fa-lg"></i>
                                </div>
                                <span>Innovation in shopping technology</span>
                            </li>
                            <li class="mb-3 d-flex align-items-start">
                                <div class="list-icon me-3">
                                    <i class="fas fa-check-circle text-primary fa-lg"></i>
                                </div>
                                <span>Sustainable business practices</span>
                            </li>
                            <li class="d-flex align-items-start">
                                <div class="list-icon me-3">
                                    <i class="fas fa-check-circle text-primary fa-lg"></i>
                                </div>
                                <span>Community building</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Core Values -->
<section class="values py-5 py-lg-6">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="display-4 fw-bold mb-3">Our Core Values</h2>
            <p class="lead text-muted mb-4">The principles that guide everything we do</p>
            <div class="section-divider mx-auto"></div>
        </div>

        <div class="row g-4">
            @php
                $values = [
                    [
                        'icon' => 'users',
                        'title' => 'Customer First',
                        'description' => 'Our customers are at the heart of everything we do. We listen, we learn, and we continuously improve to meet their needs.',
                        'color' => 'primary'
                    ],
                    [
                        'icon' => 'shield-alt',
                        'title' => 'Trust & Integrity',
                        'description' => 'We build trust through transparency, honesty, and ethical business practices in all our interactions.',
                        'color' => 'success'
                    ],
                    [
                        'icon' => 'lightbulb',
                        'title' => 'Innovation',
                        'description' => 'We embrace change and constantly seek new ways to enhance the shopping experience through technology and creativity.',
                        'color' => 'warning'
                    ],
                    [
                        'icon' => 'leaf',
                        'title' => 'Sustainability',
                        'description' => 'We\'re committed to sustainable practices that minimize our environmental impact and support local communities.',
                        'color' => 'success'
                    ],
                    [
                        'icon' => 'trophy',
                        'title' => 'Excellence',
                        'description' => 'We strive for excellence in every aspect of our business, from product quality to customer service.',
                        'color' => 'danger'
                    ],
                    [
                        'icon' => 'handshake',
                        'title' => 'Collaboration',
                        'description' => 'We believe in the power of teamwork and partnerships to achieve greater success together.',
                        'color' => 'info'
                    ]
                ];
            @endphp

            @foreach($values as $index => $value)
                <div class="col-xl-4 col-lg-6">
                    <div class="value-card p-4 h-100 hover-lift animate-fade-in" style="animation-delay: {{ $index * 0.1 }}s">
                        <div class="value-icon-wrapper mb-4">
                            <div class="value-icon rounded-circle bg-{{ $value['color'] }}-subtle d-inline-flex align-items-center justify-content-center"
                                style="width: 80px; height: 80px">
                                <i class="fas fa-{{ $value['icon'] }} fa-2x text-{{ $value['color'] }}"></i>
                            </div>
                        </div>
                        <h4 class="fw-bold mb-3">{{ $value['title'] }}</h4>
                        <p class="text-muted value-description">
                            {{ $value['description'] }}
                        </p>
                        <div class="value-number">
                            <span class="badge bg-{{ $value['color'] }}-subtle text-{{ $value['color'] }} px-3 py-1">
                                {{ $index + 1 }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Timeline -->
<section class="timeline py-5 py-lg-6 bg-light">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="display-4 fw-bold mb-3">Our Journey</h2>
            <p class="lead text-muted mb-4">Milestones in our growth story</p>
            <div class="section-divider mx-auto"></div>
        </div>

        <div class="timeline-container position-relative">
            <!-- Timeline Line -->
            <div class="timeline-line position-absolute h-100 start-50 translate-middle-x d-none d-lg-block"></div>
            
            <div class="row g-4">
                @php
                    $milestones = [
                        [
                            'year' => '2010',
                            'title' => 'The Beginning',
                            'description' => 'Founded as a small online bookstore with just 3 employees in a garage in San Francisco.',
                            'icon' => 'rocket',
                            'side' => 'left'
                        ],
                        [
                            'year' => '2013',
                            'title' => 'Expansion',
                            'description' => 'Expanded product categories to include electronics and home appliances. Reached 100,000 customers.',
                            'icon' => 'chart-line',
                            'side' => 'right'
                        ],
                        [
                            'year' => '2016',
                            'title' => 'Global Reach',
                            'description' => 'Launched international shipping to 50+ countries. Won "Best E-commerce Platform" award.',
                            'icon' => 'globe',
                            'side' => 'left'
                        ],
                        [
                            'year' => '2018',
                            'title' => 'Mobile App Launch',
                            'description' => 'Launched our mobile app with 1 million downloads in the first month. Expanded to 200+ employees.',
                            'icon' => 'mobile-alt',
                            'side' => 'right'
                        ],
                        [
                            'year' => '2020',
                            'title' => 'Pandemic Response',
                            'description' => 'Launched contactless delivery and supported small businesses during the pandemic. Reached 5M customers.',
                            'icon' => 'hands-helping',
                            'side' => 'left'
                        ],
                        [
                            'year' => '2024',
                            'title' => 'Today & Beyond',
                            'description' => 'Serving 10M+ customers worldwide with 50K+ products. Focus on AI and sustainability initiatives.',
                            'icon' => 'infinity',
                            'side' => 'right'
                        ]
                    ];
                @endphp

                @foreach($milestones as $milestone)
                    <div class="col-lg-6">
                        <div class="timeline-card p-4 h-100 hover-lift animate-fade-in {{ $milestone['side'] === 'left' ? 'me-lg-auto' : 'ms-lg-auto' }}"
                            style="max-width: 500px; animation-delay: {{ $loop->index * 0.1 }}s">
                            <div class="timeline-card-inner position-relative">
                                <div class="timeline-year d-flex align-items-center mb-3">
                                    <div class="year-badge bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                        style="width: 50px; height: 50px">
                                        <span class="fw-bold">{{ $milestone['year'] }}</span>
                                    </div>
                                    <div class="timeline-icon">
                                        <i class="fas fa-{{ $milestone['icon'] }} fa-2x text-primary"></i>
                                    </div>
                                </div>
                                <h4 class="fw-bold mb-3">{{ $milestone['title'] }}</h4>
                                <p class="text-muted mb-0">{{ $milestone['description'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="team py-5 py-lg-6">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="display-4 fw-bold mb-3">Meet Our Leadership</h2>
            <p class="lead text-muted mb-4">The visionaries behind our success</p>
            <div class="section-divider mx-auto"></div>
        </div>

        <div class="row g-4 justify-content-center">
            @php
                $team = [
                    [
                        'name' => 'John Smith',
                        'role' => 'Founder & CEO',
                        'description' => 'With 15+ years in e-commerce, John leads our vision and strategic direction.',
                        'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                        'social' => ['linkedin', 'twitter', 'envelope']
                    ],
                    [
                        'name' => 'Sarah Johnson',
                        'role' => 'Chief Technology Officer',
                        'description' => 'Sarah leads our tech team and drives innovation in our platform development.',
                        'image' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                        'social' => ['linkedin', 'github', 'envelope']
                    ],
                    [
                        'name' => 'Michael Chen',
                        'role' => 'Chief Operations Officer',
                        'description' => 'Michael ensures smooth operations and excellent customer experience across all touchpoints.',
                        'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                        'social' => ['linkedin', 'twitter', 'envelope']
                    ]
                ];
            @endphp

            @foreach($team as $member)
                <div class="col-xl-4 col-lg-6">
                    <div class="team-card text-center p-4 h-100 hover-lift animate-fade-in" style="animation-delay: {{ $loop->index * 0.1 }}s">
                        <div class="team-img-wrapper position-relative mb-4">
                            <div class="team-img rounded-circle overflow-hidden mx-auto" style="width: 180px; height: 180px">
                                <img src="{{ $member['image'] }}"
                                    alt="{{ $member['name'] }}" 
                                    class="img-fluid w-100 h-100 object-fit-cover"
                                    loading="lazy" />
                            </div>
                            <!-- Status Badge -->
                            <div class="team-status position-absolute bottom-0 end-0">
                                <div class="status-indicator bg-success rounded-circle" style="width: 20px; height: 20px"></div>
                            </div>
                        </div>
                        <h4 class="fw-bold mb-2">{{ $member['name'] }}</h4>
                        <p class="text-primary fw-semibold mb-3">{{ $member['role'] }}</p>
                        <p class="text-muted small mb-4">{{ $member['description'] }}</p>
                        <div class="social-links mt-3">
                            @foreach($member['social'] as $social)
                                <a href="#" class="social-link btn btn-outline-primary btn-icon rounded-circle me-2">
                                    <i class="fab fa-{{ $social }}"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Join Team CTA -->
        <div class="text-center mt-5 pt-5">
            <div class="join-team-card p-5 rounded-4 bg-primary text-white mx-auto" style="max-width: 800px">
                <h3 class="fw-bold mb-3">Join Our Team</h3>
                <p class="mb-4">We're always looking for talented individuals to join our growing team.</p>
                <a href="{{ route('contact') }}" class="btn btn-light btn-lg px-5 rounded-pill">
                    <i class="fas fa-briefcase me-2"></i>View Careers
                </a>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section py-5 py-lg-6">
    <div class="container">
        <div class="cta-card rounded-4 overflow-hidden shadow-lg">
            <div class="row g-0 align-items-center">
                <div class="col-lg-8 p-4 p-lg-5">
                    <div class="cta-content">
                        <h2 class="display-5 fw-bold mb-3 text-white">Join Our Growing Community</h2>
                        <p class="lead mb-4 text-white-80">
                            Be part of our journey as we continue to revolutionize online
                            shopping.
                        </p>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="cta-stat">
                                <div class="stat-number display-6 fw-bold text-white">99%</div>
                                <div class="stat-label text-white-70 small">Customer Satisfaction</div>
                            </div>
                            <div class="cta-stat">
                                <div class="stat-number display-6 fw-bold text-white">4.8</div>
                                <div class="stat-label text-white-70 small">App Rating</div>
                            </div>
                            <div class="cta-stat">
                                <div class="stat-number display-6 fw-bold text-white">24/7</div>
                                <div class="stat-label text-white-70 small">Support Available</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-4 p-lg-5 bg-white">
                    <div class="cta-actions">
                        <div class="mb-4">
                            <a href="{{ route('register') }}" class="btn btn-primary btn-lg w-100 py-3 rounded-pill mb-3">
                                <i class="fas fa-user-plus me-2"></i>Join Now
                            </a>
                            <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-lg w-100 py-3 rounded-pill">
                                <i class="fas fa-headset me-2"></i>Contact Us
                            </a>
                        </div>
                        <p class="text-muted small mb-0 text-center">
                            <i class="fas fa-lock me-1"></i>Secure & Trusted Platform
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
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
    .about-hero {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
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

    .floating-element {
        animation: float 4s ease-in-out infinite;
    }

    .floating-1 {
        top: 20%;
        left: -20px;
        animation-delay: 0s;
    }

    .floating-2 {
        bottom: 30%;
        right: -20px;
        animation-delay: 1s;
    }

    .floating-3 {
        top: 10%;
        right: 10%;
        animation-delay: 2s;
    }

    .floating-card {
        width: 70px;
        height: 70px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
    }

    /* Stats */
    .stat-card {
        background: white;
        border: 1px solid rgba(99, 102, 241, 0.1);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        border-color: var(--primary-color);
        box-shadow: 0 10px 25px rgba(99, 102, 241, 0.1);
    }

    .stat-number {
        font-size: 2.5rem;
    }

    /* Mission & Vision Cards */
    .mission-card,
    .vision-card {
        border-radius: 20px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .mission-card:hover,
    .vision-card:hover {
        transform: translateY(-8px) scale(1.01);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
    }

    .mission-list li,
    .vision-list li {
        transition: transform 0.3s ease;
    }

    .mission-list li:hover,
    .vision-list li:hover {
        transform: translateX(5px);
    }

    .list-icon {
        flex-shrink: 0;
    }

    /* Values Cards */
    .value-card {
        background: white;
        border: 1px solid rgba(0,0,0,0.05);
        border-radius: 16px;
        position: relative;
        overflow: hidden;
    }

    .value-card::before {
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

    .value-card:hover::before {
        opacity: 1;
    }

    .value-icon-wrapper {
        position: relative;
    }

    .value-icon {
        transition: all 0.3s ease;
    }

    .value-card:hover .value-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .value-description {
        line-height: 1.6;
    }

    /* Timeline */
    .timeline-line {
        width: 3px;
        background: linear-gradient(to bottom, transparent, var(--primary-color), transparent);
        z-index: 1;
    }

    .timeline-card {
        background: white;
        border: 1px solid rgba(0,0,0,0.08);
        border-radius: 16px;
        position: relative;
        z-index: 2;
    }

    .timeline-card::before {
        content: '';
        position: absolute;
        top: 50%;
        width: 20px;
        height: 20px;
        background: var(--primary-color);
        border-radius: 50%;
        transform: translateY(-50%);
        z-index: 3;
    }

    .timeline-card.left::before {
        right: -40px;
    }

    .timeline-card.right::before {
        left: -40px;
    }

    .year-badge {
        font-size: 1.2rem;
        transition: all 0.3s ease;
    }

    .timeline-card:hover .year-badge {
        transform: scale(1.1);
    }

    /* Team Cards */
    .team-card {
        background: white;
        border: 1px solid rgba(0,0,0,0.08);
        border-radius: 20px;
        transition: all 0.3s ease;
    }

    .team-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
    }

    .team-img {
        position: relative;
    }

    .team-img::after {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 50%;
        border: 3px solid transparent;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) border-box;
        -webkit-mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
        mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .team-card:hover .team-img::after {
        opacity: 1;
    }

    .social-link {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .social-link:hover {
        background: var(--primary-color) !important;
        color: white !important;
        transform: translateY(-3px);
    }

    /* CTA Section */
    .cta-card {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    }

    .cta-stat {
        flex: 1;
        min-width: 120px;
    }

    /* Join Team Card */
    .join-team-card {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        box-shadow: 0 20px 40px rgba(99, 102, 241, 0.3);
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
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .hero-title {
            font-size: 2.5rem;
        }
        
        .stat-number {
            font-size: 2rem;
        }
        
        .floating-card {
            width: 50px;
            height: 50px;
        }
        
        .floating-card i {
            font-size: 1.5rem;
        }
        
        .timeline-line,
        .timeline-card::before {
            display: none;
        }
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }
        
        .hero-description {
            font-size: 1.1rem;
        }
        
        .display-4 {
            font-size: 2.5rem;
        }
        
        .display-6 {
            font-size: 1.75rem;
        }
        
        .hero-actions .btn {
            width: 100%;
            margin-bottom: 10px;
        }
        
        .cta-actions .btn {
            width: 100%;
            margin-bottom: 10px;
        }
        
        .timeline-card {
            max-width: 100% !important;
        }
    }

    @media (max-width: 576px) {
        .hero-title {
            font-size: 1.75rem;
        }
        
        .stat-card {
            padding: 1rem !important;
        }
        
        .stat-number {
            font-size: 1.75rem;
        }
        
        .value-card {
            padding: 1.5rem !important;
        }
        
        .team-img {
            width: 150px !important;
            height: 150px !important;
        }
        
        .cta-stat {
            min-width: 100px;
        }
    }

    /* Dark Mode Support */
    @media (prefers-color-scheme: dark) {
        .about-hero {
            background: linear-gradient(135deg, #f4f5f7 0%, #1e293b 100%);
        }
        
        .hero-title {
            color: white;
        }
        
        .stat-card,
        .mission-card,
        .vision-card,
        .value-card,
        .timeline-card,
        .team-card {
            background: #e8e9eb;
            border-color: #dee3e9;
            color: #3c7fd6;
        }
        
        .text-muted {
            color: #94a3b8 !important;
        }
        
        .text-white-70,
        .text-white-80 {
            color: rgba(255,255,255,0.8) !important;
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
        
        .social-link:hover {
            transform: none;
        }
        
        .mission-list li:hover,
        .vision-list li:hover {
            transform: none;
        }
    }
</style>
@endpush 

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize animations
        initAnimations();
        
        // Initialize counter animation
        initCounterAnimation();
        
        // Initialize scroll animations
        initScrollAnimations();
        
        // Initialize team card interactions
        initTeamInteractions();
    });

    function initAnimations() {
        // Animate elements on load
        const animateElements = document.querySelectorAll('.animate-fade-in');
        animateElements.forEach((el, index) => {
            el.style.animationDelay = `${index * 0.1}s`;
            el.style.opacity = 1;
        });
    }

    function initCounterAnimation() {
        const counters = document.querySelectorAll('.counter');
        const speed = 200; // The lower the slower
        
        counters.forEach(counter => {
            const updateCount = () => {
                const target = parseInt(counter.getAttribute('data-count'));
                const count = parseInt(counter.innerText);
                const increment = Math.ceil(target / speed);
                
                if (count < target) {
                    counter.innerText = count + increment;
                    setTimeout(updateCount, 10);
                } else {
                    counter.innerText = target + '+';
                }
            };
            
            // Start counting when element is in viewport
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        updateCount();
                        observer.unobserve(entry.target);
                    }
                });
            });
            
            observer.observe(counter);
        });
    }

    function initScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in');
                    entry.target.style.opacity = 1;
                }
            });
        }, observerOptions);
        
        // Observe sections for animation
        document.querySelectorAll('section').forEach(section => {
            observer.observe(section);
        });
    }

    function initTeamInteractions() {
        // Team card hover effects
        const teamCards = document.querySelectorAll('.team-card');
        teamCards.forEach(card => {
            const img = card.querySelector('.team-img');
            const socialLinks = card.querySelectorAll('.social-link');
            
            card.addEventListener('mouseenter', () => {
                if (img) img.style.transform = 'scale(1.05)';
                socialLinks.forEach(link => {
                    link.style.transform = 'translateY(0)';
                });
            });
            
            card.addEventListener('mouseleave', () => {
                if (img) img.style.transform = 'scale(1)';
                socialLinks.forEach(link => {
                    link.style.transform = 'translateY(10px)';
                });
            });
        });
    }

    // Smooth scroll for anchor links
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

    // Social link interactions
    document.querySelectorAll('.social-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const platform = this.querySelector('i').className.split('-')[1];
            showToast(`Opening ${platform} profile...`, 'info');
            
            // In a real application, this would open the actual profile link
            setTimeout(() => {
                showToast(`Feature coming soon!`, 'info');
            }, 1000);
        });
    });

    // Toast notification function
    function showToast(message, type = 'info') {
        const toastContainer = document.getElementById('toastContainer') || createToastContainer();
        
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'error' ? 'danger' : type === 'warning' ? 'warning' : 'info'} border-0`;
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
        container.style.cssText = 'z-index: 99999; bottom: 20px; right: 20px; left: 20px; max-width: 400px; margin-left: auto; margin-right: auto;';
        document.body.appendChild(container);
        return container;
    }

    // Parallax effect for hero section
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const hero = document.querySelector('.about-hero');
        if (hero) {
            const rate = scrolled * -0.5;
            hero.style.backgroundPosition = `center ${rate}px`;
        }
    });

    // Lazy loading for images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                    }
                    img.classList.add('loaded');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
</script>
@endpush