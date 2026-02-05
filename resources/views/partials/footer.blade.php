<footer class="bg-dark text-white pt-5 pb-4 mt-5">
    <div class="container">
        <div class="row">

            <!-- Company Info -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="footer-logo mb-4">
                    <h5 class="fw-bold mb-0 d-flex align-items-center">
                        <i class="fas fa-shopping-bag me-2 fa-lg"></i>
                        <span class="brand-gradient">E-Shop</span>
                    </h5>
                </div>
                <p class="text-light mb-4">
                    Your one-stop destination for all your shopping needs. Quality products, best prices, and
                    exceptional customer service.
                </p>
                @php
                    $site = \App\Models\SiteSetting::first();
                @endphp

                <div class="social-icons mt-4">
                    @if ($site && $site->facebook)
                        <a href="{{ $site->facebook }}" target="_blank" class="social-icon facebook me-2 mb-2"
                            title="Facebook" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    @endif

                    @if ($site && $site->twitter)
                        <a href="{{ $site->twitter }}" target="_blank" class="social-icon twitter me-2 mb-2"
                            title="Twitter" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                    @endif

                    @if ($site && $site->instagram)
                        <a href="{{ $site->instagram }}" target="_blank" class="social-icon instagram me-2 mb-2"
                            title="Instagram" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                    @endif

                    @if ($site && $site->linkedin)
                        <a href="{{ $site->linkedin }}" target="_blank" class="social-icon linkedin me-2 mb-2"
                            title="LinkedIn" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    @endif

                    @if ($site && $site->youtube)
                        <a href="{{ $site->youtube }}" target="_blank" class="social-icon youtube me-2 mb-2"
                            title="YouTube" aria-label="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                    @endif

                    @if ($site && $site->pinterest)
                        <a href="{{ $site->pinterest }}" target="_blank" class="social-icon pinterest me-2 mb-2"
                            title="Pinterest" aria-label="Pinterest">
                            <i class="fab fa-pinterest-p"></i>
                        </a>
                    @endif

                    <!-- Fallback if no social links are set -->
                    @if (
                        !$site ||
                            (!$site->facebook &&
                                !$site->twitter &&
                                !$site->instagram &&
                                !$site->linkedin &&
                                !$site->youtube &&
                                !$site->pinterest))
                        <small class="text-white-50 d-block mt-2">Connect with us on social media</small>
                    @endif
                </div>

                <!-- Newsletter Subscription -->
                {{-- <div class="newsletter mt-4">
                    <h6 class="fw-bold mb-3">Stay Updated</h6>
                    <div class="input-group input-group-sm">
                        <input type="email" class="form-control bg-dark text-light border-secondary" 
                               placeholder="Enter your email" aria-label="Email for newsletter">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div> --}}
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="fw-bold mb-4 d-flex align-items-center">
                    <i class="fas fa-link me-2 fa-sm"></i>Quick Links
                </h5>
                <ul class="list-unstyled footer-links">
                    <li class="mb-2">
                        <a href="{{ route('home') }}" class="text-light text-decoration-none d-flex align-items-center hover-lift">
                            <i class="fas fa-home me-2 fa-xs"></i>Home
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('products') }}" class="text-light text-decoration-none d-flex align-items-center hover-lift">
                            <i class="fas fa-shopping-cart me-2 fa-xs"></i>Shop
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('products') }}" class="text-light text-decoration-none d-flex align-items-center hover-lift">
                            <i class="fas fa-list me-2 fa-xs"></i>Categories
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('about') }}" class="text-light text-decoration-none d-flex align-items-center hover-lift">
                            <i class="fas fa-info-circle me-2 fa-xs"></i>About Us
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('contact') }}" class="text-light text-decoration-none d-flex align-items-center hover-lift">
                            <i class="fas fa-envelope me-2 fa-xs"></i>Contact
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Categories -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="fw-bold mb-4 d-flex align-items-center">
                    <i class="fas fa-tags me-2 fa-sm"></i>Categories
                </h5>
                <ul class="list-unstyled footer-links">
                    @php
                        $footerCategories = \App\Models\Category::where('status', 'active')->limit(5)->get();
                    @endphp

                    @forelse($footerCategories as $cat)
                        <li class="mb-2">
                            <a href="{{ route('category.products', $cat->slug) }}" 
                               class="text-light text-decoration-none d-flex align-items-center hover-lift">
                                <i class="fas fa-chevron-right me-2 fa-xs"></i>{{ $cat->name }}
                            </a>
                        </li>
                    @empty
                        <li class="text-muted">
                            <i class="fas fa-exclamation-circle me-2 fa-xs"></i>No categories found
                        </li>
                    @endforelse
                    
                    {{-- @if(count($footerCategories) > 0)
                        <li class="mt-3">
                            <a href="{{ route('products') }}" class="text-primary text-decoration-none fw-semibold">
                                View All Categories <i class="fas fa-arrow-right ms-1 fa-xs"></i>
                            </a>
                        </li>
                    @endif --}}
                </ul>
            </div>

            <!-- Contact Info -->
            @php
                $site = \App\Models\SiteSetting::first();
            @endphp

            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="fw-bold mb-4 d-flex align-items-center">
                    <i class="fas fa-address-card me-2 fa-sm"></i>Contact Us
                </h5>
                <ul class="list-unstyled contact-info">
                    <li class="mb-3 d-flex align-items-start">
                        <div class="contact-icon me-3">
                            <i class="fas fa-map-marker-alt text-primary"></i>
                        </div>
                        <div>
                            <span class="fw-semibold d-block">Address</span>
                            <span class="text-light">{{ $site->address ?? '123 Street, City, Country' }}</span>
                        </div>
                    </li>
                    
                    <li class="mb-3 d-flex align-items-start">
                        <div class="contact-icon me-3">
                            <i class="fas fa-phone text-primary"></i>
                        </div>
                        <div>
                            <span class="fw-semibold d-block">Phone</span>
                            <a href="tel:{{ $site->phone_1 ?? '+12345678900' }}" class="text-light text-decoration-none">
                                {{ $site->phone_1 ?? '+1 234 567 8900' }}
                            </a>
                            @if ($site && $site->phone_2)
                                <br>
                                <a href="tel:{{ $site->phone_2 }}" class="text-light text-decoration-none">
                                    {{ $site->phone_2 }}
                                </a>
                            @endif
                        </div>
                    </li>
                    
                    <li class="mb-3 d-flex align-items-start">
                        <div class="contact-icon me-3">
                            <i class="fas fa-envelope text-primary"></i>
                        </div>
                        <div>
                            <span class="fw-semibold d-block">Email</span>
                            <a href="mailto:{{ $site->email_support ?? 'info@eshop.com' }}" 
                               class="text-light text-decoration-none">
                                {{ $site->email_support ?? 'info@eshop.com' }}
                            </a>
                        </div>
                    </li>
                    
                    {{-- <li class="d-flex align-items-start">
                        <div class="contact-icon me-3">
                            <i class="fas fa-clock text-primary"></i>
                        </div>
                        <div>
                            <span class="fw-semibold d-block">Business Hours</span>
                            <span class="text-light">Mon - Fri: 9:00 - 18:00</span>
                            <br>
                            <span class="text-light">Sat - Sun: 10:00 - 16:00</span>
                        </div>
                    </li> --}}
                </ul>
            </div>

        </div>

        <!-- Payment Methods -->
        {{-- <div class="row py-4">
            <div class="col-12">
                <div class="border-top border-secondary pt-4">
                    <h6 class="fw-bold mb-3 text-center text-md-start">We Accept</h6>
                    <div class="d-flex flex-wrap justify-content-center justify-content-md-start align-items-center gap-3">
                        <div class="payment-method">
                            <i class="fab fa-cc-visa fa-2x text-light"></i>
                        </div>
                        <div class="payment-method">
                            <i class="fab fa-cc-mastercard fa-2x text-light"></i>
                        </div>
                        <div class="payment-method">
                            <i class="fab fa-cc-paypal fa-2x text-light"></i>
                        </div>
                        <div class="payment-method">
                            <i class="fab fa-cc-apple-pay fa-2x text-light"></i>
                        </div>
                        <div class="payment-method">
                            <i class="fab fa-cc-amazon-pay fa-2x text-light"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <hr class="bg-secondary my-0">

        <!-- Copyright -->
        <div class="row pt-4">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <p class="mb-2">
                    &copy; {{ date('Y') }} <strong>E-Shop</strong>. All rights reserved.
                </p>
                <p class="mb-0">
                    <small>
                        Designed & Developed with 
                        <i class="fas fa-heart text-danger mx-1"></i> 
                        by <strong class="text-primary">Laxman Pradhan</strong>
                    </small>
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <div class="d-flex flex-column flex-md-row justify-content-center justify-content-md-end align-items-center gap-3">
                    <a href="{{ route('about') }}" class="text-light text-decoration-none hover-lift">
                        <i class="fas fa-shield-alt me-1"></i> Privacy Policy
                    </a>
                    <span class="d-none d-md-inline text-secondary">|</span>
                    <a href="{{ route('about') }}" class="text-light text-decoration-none hover-lift">
                        <i class="fas fa-file-contract me-1"></i> Terms of Service
                    </a>
                    <span class="d-none d-md-inline text-secondary">|</span>
                    <a href="{{ route('about') }}" class="text-light text-decoration-none hover-lift">
                        <i class="fas fa-cookie me-1"></i> Cookie Policy
                    </a>
                </div>
                <div class="mt-2">
                    <small class="text-white-50">
                        <i class="fas fa-lock me-1"></i> Secure Shopping | 
                        <i class="fas fa-truck ms-2 me-1"></i> Free Shipping on Orders Over $50
                    </small>
                </div>
            </div>
        </div>

    </div>

    <!-- Back to top button for footer -->
    <div class="text-center py-3 border-top border-secondary">
        <button class="btn btn-outline-light btn-sm back-to-top-footer" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
            <i class="fas fa-chevron-up me-1"></i> Back to Top
        </button>
    </div>

    <style>
        /* Enhanced Footer Styles */
        .footer-logo .brand-gradient {
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .social-icons {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            font-size: 1.1rem;
        }

        .social-icons a:hover {
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .social-icons a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.7s ease;
        }

        .social-icons a:hover::before {
            left: 100%;
        }

        /* Social media brand colors */
        .social-icon.facebook {
            background: linear-gradient(135deg, #1877f2, #0d5fbf);
            color: white;
        }

        .social-icon.twitter {
            background: linear-gradient(135deg, #1da1f2, #0c85d0);
            color: white;
        }

        .social-icon.instagram {
            background: linear-gradient(45deg, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d);
            color: white;
        }

        .social-icon.linkedin {
            background: linear-gradient(135deg, #0077b5, #005582);
            color: white;
        }

        .social-icon.youtube {
            background: linear-gradient(135deg, #ff0000, #cc0000);
            color: white;
        }

        .social-icon.pinterest {
            background: linear-gradient(135deg, #e60023, #b3001b);
            color: white;
        }

        /* Footer Links */
        .footer-links a {
            transition: all 0.3s ease;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .footer-links a:hover {
            background: rgba(255, 255, 255, 0.1);
            padding-left: 12px;
            color: #fff !important;
        }

        .footer-links i {
            transition: transform 0.3s ease;
        }

        .footer-links a:hover i {
            transform: translateX(3px);
        }

        /* Contact Info */
        .contact-icon {
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .contact-info a:hover {
            color: #4dabf7 !important;
            text-decoration: underline !important;
        }

        /* Payment Methods */
        .payment-method {
            padding: 8px 16px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .payment-method:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        /* Newsletter */
        .newsletter input:focus {
            background: #2d3748 !important;
            border-color: #4dabf7 !important;
            box-shadow: 0 0 0 0.25rem rgba(77, 171, 247, 0.25) !important;
        }

        /* Back to top button */
        .back-to-top-footer {
            transition: all 0.3s ease;
            border-width: 2px;
        }

        .back-to-top-footer:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        /* Hover lift effect */
        .hover-lift {
            transition: transform 0.2s ease;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .social-icons {
                justify-content: center;
            }
            
            .footer-links a,
            .contact-info li {
                padding-left: 0;
            }
            
            .payment-method {
                padding: 6px 12px;
            }
            
            .payment-method i {
                font-size: 1.5rem;
            }
            
            .newsletter .input-group {
                max-width: 300px;
                margin: 0 auto;
            }
        }

        @media (max-width: 576px) {
            .footer-logo h5 {
                font-size: 1.25rem;
            }
            
            .social-icons a {
                width: 38px;
                height: 38px;
                font-size: 1rem;
            }
            
            .contact-icon {
                width: 32px;
                height: 32px;
                font-size: 0.9rem;
            }
            
            .payment-method {
                padding: 4px 8px;
            }
            
            .payment-method i {
                font-size: 1.25rem;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            footer {
                background: #1a202c !important;
            }
            
            .social-icons a {
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
            }
        }

        /* Animation for new elements */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .newsletter,
        .payment-methods-section {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>

    <!-- Optional JavaScript for newsletter -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Newsletter form submission
            const newsletterForm = document.querySelector('.newsletter .btn');
            if (newsletterForm) {
                newsletterForm.addEventListener('click', function(e) {
                    e.preventDefault();
                    const emailInput = this.parentElement.querySelector('input[type="email"]');
                    const email = emailInput.value.trim();
                    
                    if (!email) {
                        showToast('error', 'Please enter your email address');
                        emailInput.focus();
                        return;
                    }
                    
                    if (!validateEmail(email)) {
                        showToast('error', 'Please enter a valid email address');
                        emailInput.focus();
                        return;
                    }
                    
                    // Show loading state
                    const originalHTML = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    this.disabled = true;
                    
                    // Simulate API call (replace with actual API call)
                    setTimeout(() => {
                        showToast('success', 'Thank you for subscribing to our newsletter!');
                        emailInput.value = '';
                        this.innerHTML = originalHTML;
                        this.disabled = false;
                    }, 1500);
                });
            }
            
            // Email validation
            function validateEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }
            
            // Toast function (use the one from your main layout)
            function showToast(type, message) {
                if (window.Cart && window.Cart.showToast) {
                    window.Cart.showToast(type, message);
                } else {
                    // Fallback toast
                    alert(message);
                }
            }
        });
    </script>
</footer>