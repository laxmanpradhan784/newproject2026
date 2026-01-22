@extends('layouts.app')

@section('title', 'About Us - E-Shop')

@section('content')
<!-- Hero Section -->
<section class="contact-hero py-5 bg-light">
    <div class="container pt-5">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Our Story</h1>
                <p class="lead mb-4">Founded in 2010, E-Shop has grown from a small startup to one of the leading e-commerce platforms, serving millions of satisfied customers worldwide.</p>
                <div class="d-flex gap-3">
                    <div class="text-center">
                        <h2 class="text-primary fw-bold">10M+</h2>
                        <p class="text-muted">Happy Customers</p>
                    </div>
                    <div class="text-center">
                        <h2 class="text-primary fw-bold">50K+</h2>
                        <p class="text-muted">Products</p>
                    </div>
                    <div class="text-center">
                        <h2 class="text-primary fw-bold">100+</h2>
                        <p class="text-muted">Countries</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                     alt="About Us" class="img-fluid rounded-3 shadow">
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="mission-vision py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-5">
                        <div class="icon-wrapper mb-4">
                            <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center" 
                                 style="width: 60px; height: 60px;">
                                <i class="fas fa-bullseye fa-2x text-white"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold mb-4">Our Mission</h3>
                        <p class="mb-4">To provide customers with an exceptional online shopping experience by offering high-quality products, competitive prices, and unparalleled customer service.</p>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Quality products at best prices</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Fast and reliable delivery</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> 24/7 customer support</li>
                            <li><i class="fas fa-check-circle text-primary me-2"></i> Secure shopping experience</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-5">
                        <div class="icon-wrapper mb-4">
                            <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center" 
                                 style="width: 60px; height: 60px;">
                                <i class="fas fa-eye fa-2x text-white"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold mb-4">Our Vision</h3>
                        <p class="mb-4">To become the world's most customer-centric e-commerce platform, where people can discover and purchase anything they need online.</p>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Global e-commerce leader</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Innovation in shopping technology</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Sustainable business practices</li>
                            <li><i class="fas fa-check-circle text-primary me-2"></i> Community building</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Core Values -->
<section class="values py-5">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>Our Core Values</h2>
            <p class="text-muted">The principles that guide everything we do</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="value-card text-center p-4 h-100">
                    <div class="value-icon mb-4">
                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-3">Customer First</h4>
                    <p class="text-muted">Our customers are at the heart of everything we do. We listen, we learn, and we continuously improve to meet their needs.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card text-center p-4 h-100">
                    <div class="value-icon mb-4">
                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-shield-alt fa-2x text-primary"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-3">Trust & Integrity</h4>
                    <p class="text-muted">We build trust through transparency, honesty, and ethical business practices in all our interactions.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card text-center p-4 h-100">
                    <div class="value-icon mb-4">
                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-lightbulb fa-2x text-primary"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-3">Innovation</h4>
                    <p class="text-muted">We embrace change and constantly seek new ways to enhance the shopping experience through technology and creativity.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card text-center p-4 h-100">
                    <div class="value-icon mb-4">
                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-leaf fa-2x text-primary"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-3">Sustainability</h4>
                    <p class="text-muted">We're committed to sustainable practices that minimize our environmental impact and support local communities.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card text-center p-4 h-100">
                    <div class="value-icon mb-4">
                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-trophy fa-2x text-primary"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-3">Excellence</h4>
                    <p class="text-muted">We strive for excellence in every aspect of our business, from product quality to customer service.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card text-center p-4 h-100">
                    <div class="value-icon mb-4">
                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-handshake fa-2x text-primary"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-3">Collaboration</h4>
                    <p class="text-muted">We believe in the power of teamwork and partnerships to achieve greater success together.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Timeline -->
<section class="timeline py-5 bg-light">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>Our Journey</h2>
            <p class="text-muted">Milestones in our growth story</p>
        </div>
        
        <div class="timeline-steps">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="timeline-card p-4 h-100">
                        <div class="timeline-year text-primary fw-bold mb-2">2010</div>
                        <h4 class="fw-bold mb-3">The Beginning</h4>
                        <p>Founded as a small online bookstore with just 3 employees in a garage in San Francisco.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="timeline-card p-4 h-100">
                        <div class="timeline-year text-primary fw-bold mb-2">2013</div>
                        <h4 class="fw-bold mb-3">Expansion</h4>
                        <p>Expanded product categories to include electronics and home appliances. Reached 100,000 customers.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="timeline-card p-4 h-100">
                        <div class="timeline-year text-primary fw-bold mb-2">2016</div>
                        <h4 class="fw-bold mb-3">Global Reach</h4>
                        <p>Launched international shipping to 50+ countries. Won "Best E-commerce Platform" award.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="timeline-card p-4 h-100">
                        <div class="timeline-year text-primary fw-bold mb-2">2018</div>
                        <h4 class="fw-bold mb-3">Mobile App Launch</h4>
                        <p>Launched our mobile app with 1 million downloads in the first month. Expanded to 200+ employees.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="timeline-card p-4 h-100">
                        <div class="timeline-year text-primary fw-bold mb-2">2020</div>
                        <h4 class="fw-bold mb-3">Pandemic Response</h4>
                        <p>Launched contactless delivery and supported small businesses during the pandemic. Reached 5M customers.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="timeline-card p-4 h-100">
                        <div class="timeline-year text-primary fw-bold mb-2">2024</div>
                        <h4 class="fw-bold mb-3">Today & Beyond</h4>
                        <p>Serving 10M+ customers worldwide with 50K+ products. Focus on AI and sustainability initiatives.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="team py-5">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>Meet Our Leadership</h2>
            <p class="text-muted">The visionaries behind our success</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="team-card text-center">
                    <div class="team-img mb-4">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             alt="CEO" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <h4 class="fw-bold mb-2">John Smith</h4>
                    <p class="text-primary mb-3">Founder & CEO</p>
                    <p class="text-muted small">With 15+ years in e-commerce, John leads our vision and strategic direction.</p>
                    <div class="social-links mt-3">
                        <a href="#" class="text-muted me-3"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-muted me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-muted"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="team-card text-center">
                    <div class="team-img mb-4">
                        <img src="https://images.unsplash.com/photo-1494790108755-2616b786d4d9?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             alt="CTO" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <h4 class="fw-bold mb-2">Sarah Johnson</h4>
                    <p class="text-primary mb-3">Chief Technology Officer</p>
                    <p class="text-muted small">Sarah leads our tech team and drives innovation in our platform development.</p>
                    <div class="social-links mt-3">
                        <a href="#" class="text-muted me-3"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-muted me-3"><i class="fab fa-github"></i></a>
                        <a href="#" class="text-muted"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="team-card text-center">
                    <div class="team-img mb-4">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             alt="COO" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <h4 class="fw-bold mb-2">Michael Chen</h4>
                    <p class="text-primary mb-3">Chief Operations Officer</p>
                    <p class="text-muted small">Michael ensures smooth operations and excellent customer experience across all touchpoints.</p>
                    <div class="social-links mt-3">
                        <a href="#" class="text-muted me-3"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-muted me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-muted"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="fw-bold mb-3">Join Our Growing Community</h2>
                <p class="mb-0">Be part of our journey as we continue to revolutionize online shopping.</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5">Join Now</a>
                <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg ms-3 px-5">Contact Us</a>
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
    .about-hero {
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
    
    /* Cards */
    .value-card, .timeline-card, .team-card {
        transition: all 0.3s ease;
        border-radius: 15px;
        background: white;
    }
    
    .value-card:hover, .timeline-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
    }
    
    .team-card {
        padding: 30px;
        border: 1px solid #eee;
    }
    
    .team-card:hover {
        border-color: var(--primary-color);
    }
    
    /* Timeline */
    .timeline-year {
        font-size: 1.5rem;
    }
    
    .timeline-card {
        border-left: 4px solid var(--primary-color);
        height: 100%;
    }
    
    /* Mission & Vision Cards */
    .mission-vision .card {
        border-radius: 15px;
        transition: all 0.3s ease;
    }
    
    .mission-vision .card:hover {
        transform: translateY(-10px);
    }
    
    /* Social Links */
    .social-links a {
        transition: color 0.3s ease;
    }
    
    .social-links a:hover {
        color: var(--primary-color) !important;
    }
    
    /* CTA Section */
    .cta-section {
        background: linear-gradient(to right, var(--primary-color), #7209b7);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .about-hero h1 {
            font-size: 2.5rem;
        }
        
        .mission-vision .card-body {
            padding: 2rem !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Counter animation
        $('.display-4').each(function() {
            if($(this).text().includes('+')) {
                const $this = $(this);
                const countTo = parseInt($this.text());
                $({ countNum: 0 }).animate({
                    countNum: countTo
                }, {
                    duration: 2000,
                    easing: 'swing',
                    step: function() {
                        $this.text(Math.floor(this.countNum) + '+');
                    },
                    complete: function() {
                        $this.text(countTo + '+');
                    }
                });
            }
        });
        
        // Team card hover effect
        $('.team-card').hover(
            function() {
                $(this).css('transform', 'translateY(-10px)');
            },
            function() {
                $(this).css('transform', 'translateY(0)');
            }
        );
        
        // Smooth scroll for anchor links
        $('a[href^="#"]').on('click', function(event) {
            if (this.hash !== "") {
                event.preventDefault();
                const hash = this.hash;
                $('html, body').animate({
                    scrollTop: $(hash).offset().top - 80
                }, 800);
            }
        });
    });
</script>
@endpush