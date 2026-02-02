<footer class="bg-dark text-white pt-5 pb-4 mt-5">
    <div class="container">
        <div class="row">

            <!-- Company Info -->
            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="fw-bold mb-4">
                    <i class="fas fa-shopping-bag me-2"></i>E-Shop
                </h5>
                <p class="text-light">
                    Your one-stop destination for all your shopping needs. Quality products, best prices, and
                    exceptional customer service.
                </p>
                @php
                    $site = \App\Models\SiteSetting::first();
                @endphp

                <div class="social-icons mt-4">
                    @if ($site && $site->facebook)
                        <a href="{{ $site->facebook }}" target="_blank" class="social-icon facebook me-3"
                            title="Facebook">
                            <i class="fab fa-facebook-f fa-lg"></i>
                        </a>
                    @endif

                    @if ($site && $site->twitter)
                        <a href="{{ $site->twitter }}" target="_blank" class="social-icon twitter me-3" title="Twitter">
                            <i class="fab fa-twitter fa-lg"></i>
                        </a>
                    @endif

                    @if ($site && $site->instagram)
                        <a href="{{ $site->instagram }}" target="_blank" class="social-icon instagram me-3"
                            title="Instagram">
                            <i class="fab fa-instagram fa-lg"></i>
                        </a>
                    @endif

                    @if ($site && $site->linkedin)
                        <a href="{{ $site->linkedin }}" target="_blank" class="social-icon linkedin me-3"
                            title="LinkedIn">
                            <i class="fab fa-linkedin-in fa-lg"></i>
                        </a>
                    @endif

                    @if ($site && $site->youtube)
                        <a href="{{ $site->youtube }}" target="_blank" class="social-icon youtube me-3" title="YouTube">
                            <i class="fab fa-youtube fa-lg"></i>
                        </a>
                    @endif

                    @if ($site && $site->pinterest)
                        <a href="{{ $site->pinterest }}" target="_blank" class="social-icon pinterest"
                            title="Pinterest">
                            <i class="fab fa-pinterest-p fa-lg"></i>
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
                        <small class="text-white-50">Connect with us on social media</small>
                    @endif
                </div>

                <style>
                    .social-icons a {
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                        width: 40px;
                        height: 40px;
                        border-radius: 50%;
                        text-decoration: none;
                        transition: all 0.3s ease;
                        position: relative;
                        overflow: hidden;
                    }

                    .social-icons a:hover {
                        transform: translateY(-3px);
                        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
                    }

                    .social-icons a::before {
                        content: '';
                        position: absolute;
                        top: 0;
                        left: -100%;
                        width: 100%;
                        height: 100%;
                        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
                        transition: left 0.5s ease;
                    }

                    .social-icons a:hover::before {
                        left: 100%;
                    }

                    /* Social media brand colors */
                    .social-icon.facebook {
                        background: #1877f2;
                        color: white;
                    }

                    .social-icon.facebook:hover {
                        background: #166fe5;
                        color: white;
                    }

                    .social-icon.twitter {
                        background: #1da1f2;
                        color: white;
                    }

                    .social-icon.twitter:hover {
                        background: #1a91da;
                        color: white;
                    }

                    .social-icon.instagram {
                        background: linear-gradient(45deg, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d);
                        color: white;
                    }

                    .social-icon.instagram:hover {
                        opacity: 0.9;
                        color: white;
                    }

                    .social-icon.linkedin {
                        background: #0077b5;
                        color: white;
                    }

                    .social-icon.linkedin:hover {
                        background: #00669c;
                        color: white;
                    }

                    .social-icon.youtube {
                        background: #ff0000;
                        color: white;
                    }

                    .social-icon.youtube:hover {
                        background: #e60000;
                        color: white;
                    }

                    .social-icon.pinterest {
                        background: #e60023;
                        color: white;
                    }

                    .social-icon.pinterest:hover {
                        background: #cc001f;
                        color: white;
                    }
                </style>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="fw-bold mb-4">Quick Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('home') }}" class="text-light text-decoration-none">Home</a>
                    </li>
                    <li class="mb-2"><a href="{{ route('products') }}"
                            class="text-light text-decoration-none">Shop</a></li>
                    <li class="mb-2"><a href="{{ route('products') }}"
                            class="text-light text-decoration-none">Categories</a></li>
                    <li class="mb-2"><a href="{{ route('about') }}" class="text-light text-decoration-none">About
                            Us</a></li>
                    <li class="mb-2"><a href="{{ route('contact') }}"
                            class="text-light text-decoration-none">Contact</a></li>
                </ul>
            </div>

            <!-- Categories -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="fw-bold mb-4">Categories</h5>
                <ul class="list-unstyled">

                    @php
                        $footerCategories = \App\Models\Category::where('status', 'active')->limit(5)->get();
                    @endphp

                    @forelse($footerCategories as $cat)
                        <li class="mb-2">
                            <a href="{{ route('category.products', $cat->slug) }}"
                                class="text-light text-decoration-none">
                                {{ $cat->name }}
                            </a>
                        </li>
                    @empty
                        <li class="text-muted">No categories found</li>
                    @endforelse

                </ul>
            </div>


            <!-- Contact Info -->
            @php
                $site = \App\Models\SiteSetting::first();
            @endphp

            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="fw-bold mb-4">Contact Us</h5>
                <ul class="list-unstyled">
                    <li class="mb-3">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        {{ $site->address ?? '123 Street, City, Country' }}
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-phone me-2"></i>
                        {{ $site->phone_1 ?? '+1 234 567 8900' }}
                        @if ($site && $site->phone_2)
                        @endif
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-envelope me-2"></i>
                        {{ $site->email_support ?? 'info@eshop.com' }}
                    </li>
                    <li>
                        <i class="fas fa-clock me-2"></i>
                        Mon - Fri: 9:00 - 18:00
                    </li>
                </ul>
            </div>

        </div>

        <hr class="bg-light">

        <!-- Copyright -->
        <!-- Copyright -->
        <div class="row">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0">
                    &copy; {{ date('Y') }} E-Shop. All rights reserved. <br>
                    <small>Designed & Developed with ❤️ by <strong>Laxman Pradhan</strong></small>
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <a href="{{ route('about') }}" class="text-light text-decoration-none me-3">Privacy Policy</a>
                <a href="{{ route('about') }}" class="text-light text-decoration-none">Terms of Service</a>
            </div>
        </div>

    </div>
</footer>
