@php
    // Get wishlist count FIRST before using it anywhere
    use App\Models\Wishlist;
    use App\Models\Cart;

    // Initialize variables
    $wishlistCount = 0;
    $cartProductCount = 0;

    // Calculate wishlist count
    if (auth()->check()) {
        // For logged-in users: count from database
        $wishlistCount = Wishlist::where('user_id', auth()->id())->count();
    } else {
        // For guest users: count from session
        $wishlistCount = count(session()->get('wishlist', []));
    }

    // Calculate cart count
    if (auth()->check()) {
        // For logged-in users: count distinct products (not quantity)
        $cartProductCount = Cart::where('user_id', auth()->id())
            ->where('is_guest', false)
            ->count();
    } else {
        // For guest users: count distinct products
        $cartProductCount = Cart::where(function ($query) {
            if (session()->has('guest_token')) {
                $query->where('guest_token', session('guest_token'));
            }
            $query->orWhere('session_id', session()->getId());
        })
            ->where('is_guest', true)
            ->count();
    }
@endphp
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top"
    style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);">
    <div class="container">

        <!-- Brand with gradient -->
        <a class="navbar-brand fw-bold gradient-text" href="{{ route('home') }}">
            <i class="fas fa-shopping-bag me-2"></i>
            <span class="brand-text">E-Shop</span>
        </a>

        <!-- Mobile Actions (Cart/Wishlist before toggle) -->
        <div class="d-flex d-lg-none align-items-center order-lg-1">
            <!-- Mobile Wishlist -->
            <a class="btn btn-float btn-wishlist me-2" href="{{ route('wishlist.index') }}" aria-label="Wishlist">
                <i class="fas fa-heart"></i>
                @if ($wishlistCount > 0)
                    <span class="badge-count wishlist-mobile-count">{{ $wishlistCount }}</span>
                @endif
            </a>

            <!-- Mobile Cart -->
            <a class="btn btn-float btn-cart me-3" href="{{ route('cart') }}" aria-label="Cart">
                <i class="fas fa-shopping-cart"></i>
                @if ($cartProductCount > 0)
                    <span class="badge-count cart-mobile-count">{{ $cartProductCount }}</span>
                @endif
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars text-primary animated-icon"></i>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="d-flex w-100 align-items-center">

                <!-- CENTER MENU -->
                <ul class="navbar-nav mx-lg-auto mb-3 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link nav-hover" href="{{ route('home') }}">
                            <i class="fas fa-home me-1 d-lg-none"></i>
                            <span class="nav-text">Home</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle nav-hover py-2 px-3" href="#" data-bs-toggle="dropdown"
                            aria-expanded="false" role="button">
                            <span class="nav-text">Categories</span>
                        </a>
                        <ul class="dropdown-menu dropdown-animate shadow border-0 p-0" style="min-width: 180px;"
                            aria-labelledby="categoriesDropdown">
                            @php
                                $categories = \App\Models\Category::where('status', 'active')->get();
                            @endphp

                            @foreach ($categories as $cat)
                                <li>
                                    <a class="dropdown-item dropdown-hover px-3 py-2 d-flex align-items-center border-bottom"
                                        href="{{ route('category.products', $cat->slug) }}">
                                        <i
                                            class="fas fa-{{ $cat->icon ?? 'chevron-right' }} fa-xs me-2 text-primary"></i>
                                        <span class="flex-grow-1">{{ $cat->name }}</span>
                                        @if ($cat->product_count > 0)
                                            <span
                                                class="badge bg-primary bg-opacity-10 text-primary px-1 py-0">{{ $cat->product_count }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endforeach

                            <li>
                                <a class="dropdown-item dropdown-hover px-3 py-2 d-flex align-items-center text-primary fw-semibold border-top"
                                    href="{{ route('products') }}">
                                    <i class="fas fa-list me-2"></i>
                                    <span>View All</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-hover" href="{{ route('products') }}">
                            <i class="fas fa-box me-1 d-lg-none"></i>
                            <span class="nav-text">Products</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-hover" href="{{ route('about') }}">
                            <i class="fas fa-info-circle me-1 d-lg-none"></i>
                            <span class="nav-text">About</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-hover" href="{{ route('contact') }}">
                            <i class="fas fa-envelope me-1 d-lg-none"></i>
                            <span class="nav-text">Contact</span>
                        </a>
                    </li>
                </ul>

                <!-- RIGHT SIDE (Desktop Only) -->
                <div class="d-none d-lg-flex align-items-center ms-lg-auto nav-right">

                    <!-- Search with animation (Desktop Only) -->
                    <div class="search-container me-3 d-none d-lg-block">
                        <form class="d-flex search-form" action="{{ route('product.search') }}" method="GET"
                            role="search">

                            <button class="search-btn" type="submit" aria-label="Search">
                                <i class="fas fa-search"></i>
                            </button>

                            <input class="search-input" type="search" name="q" placeholder="Search products..."
                                aria-label="Search products" autocomplete="off">
                        </form>

                        <!-- Search suggestions dropdown -->
                        <div class="search-suggestions dropdown-menu" id="searchSuggestions"></div>
                    </div>


                    <!-- Desktop Wishlist -->
                    <a class="btn btn-float btn-wishlist me-2" href="{{ route('wishlist.index') }}"
                        aria-label="Wishlist" title="Wishlist">
                        <i class="fas fa-heart"></i>
                        @if ($wishlistCount > 0)
                            <span class="badge-count desktop-wishlist-count">{{ $wishlistCount }}</span>
                        @endif
                    </a>

                    <!-- Desktop Cart -->
                    <a class="btn btn-float btn-cart me-3" href="{{ route('cart') }}" aria-label="Cart" title="Cart">
                        <i class="fas fa-shopping-cart"></i>
                        @if ($cartProductCount > 0)
                            <span class="badge-count desktop-cart-count">{{ $cartProductCount }}</span>
                        @endif
                    </a>

                    @auth
                        <!-- User with avatar -->
                        <div class="dropdown user-dropdown rounded-border">
                            <a class="dropdown-toggle user-avatar" data-bs-toggle="dropdown" aria-expanded="false"
                                role="button" id="userDropdown">
                                <div class="avatar-initials">
                                    {{ substr(Auth::user()->first_name, 0, 1) }}{{ substr(Auth::user()->last_name ?? '', 0, 1) }}
                                </div>
                                <span class="user-name ms-2">{{ Auth::user()->first_name }}</span>
                                <i class="fas fa-chevron-down ms-1"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-animate" aria-labelledby="userDropdown">
                                {{-- <li>
                                    <h6 class="dropdown-header">
                                        <i class="fas fa-user-circle me-2"></i>
                                        {{ Auth::user()->first_name }} {{ Auth::user()->last_name ?? '' }}
                                    </h6>
                                </li> --}}
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item dropdown-hover" href="{{ route('profile') }}">
                                        <i class="fas fa-user me-2"></i> My Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item dropdown-hover" href="{{ route('orders') }}">
                                        <i class="fas fa-shopping-bag me-2"></i> My Orders
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item dropdown-hover" href="{{ route('payments.index') }}">
                                        <i class="fas fa-shopping-bag me-2"></i> Payment History
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item dropdown-hover" href="{{ route('returns.index') }}">
                                        <i class="fas fa-exchange-alt me-2"></i> My Returns
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item dropdown-hover" href="{{ route('reviews.my') }}">
                                        <i class="fas fa-star me-2"></i> My Reviews
                                    </a>
                                </li>
                                {{-- <li>
                                    <a class="dropdown-item dropdown-hover" href="{{ route('wishlist.index') }}">
                                        <i class="fas fa-heart me-2"></i> My Wishlist
                                        @if ($wishlistCount > 0)
                                            <span class="badge bg-danger float-end">{{ $wishlistCount }}</span>
                                        @endif
                                    </a>
                                </li> --}}
                                @if (Auth::user()->is_admin)
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item dropdown-hover text-warning"
                                            href="{{ route('admin.dashboard') }}">
                                            <i class="fas fa-crown me-2"></i> Admin Panel
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="mb-0">
                                        @csrf
                                        <button class="dropdown-item dropdown-hover text-danger" type="submit">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endauth

                    @guest
                        <!-- Auth buttons with hover effects -->
                        <div class="auth-buttons">
                            <a href="{{ route('login') }}" class="btn btn-outline-primary me-2 btn-hover">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-primary btn-gradient me-2 btn-hover">
                                <i class="fas fa-user-plus me-1"></i> Register
                            </a>
                        </div>
                    @endguest

                </div>
            </div>

            <!-- Mobile Search Toggle Button -->
            <div class="d-block d-lg-none mt-3 text-center">
                <button class="btn btn-outline-secondary btn-sm w-100" type="button" id="mobileSearchToggle">
                    <i class="fas fa-search me-2"></i> Search Products
                </button>
            </div>

            <!-- Mobile Search (Hidden by default) -->
            <div class="mobile-search-container d-none mt-3">
                <form class="d-flex" action="{{ route('product.search') }}" role="search">
                    <div class="input-group">
                        <input type="search" class="form-control" placeholder="What are you looking for?"
                            aria-label="Search products" autocomplete="off">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
                <div class="search-suggestions-mobile mt-2"></div>
            </div>
        </div>
    </div>
</nav>

<style>
    /* Variables for consistent theming */
    :root {
        --primary-color: #6366f1;
        --primary-hover: #4f46e5;
        --secondary-color: #ec4899;
        --success-color: #10b981;
        --danger-color: #ef4444;
        --warning-color: #f59e0b;
        --dark-color: #1f2937;
        --light-color: #f9fafb;
        --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.07);
        --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Mobile Navigation Container */
    @media (max-width: 992px) {
        .navbar-collapse {
            background: white;
            padding: 1rem;
            border-radius: 0 0 1rem 1rem;
            box-shadow: var(--shadow-lg);
            margin-top: 0.5rem;
            max-height: 80vh;
            overflow-y: auto;
        }

        .navbar-nav {
            width: 100%;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            text-align: left;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        /* Mobile specific styles for cart/wishlist badges */
        .btn-float {
            width: 44px;
            height: 44px;
        }

        /* Hide desktop elements on mobile */
        .nav-right {
            display: none !important;
        }

        /* Show mobile actions */
        .d-lg-none .btn-float {
            background: transparent;
            border: none;
            box-shadow: none;
        }

        /* Mobile search container */
        .mobile-search-container {
            animation: slideDown 0.3s ease;
        }

        .mobile-search-container .input-group {
            border-radius: 0.75rem;
            overflow: hidden;
            border: 2px solid var(--primary-color);
        }

        .mobile-search-container input {
            border: none;
            padding: 0.75rem;
            font-size: 1rem;
        }

        .mobile-search-container button {
            border-radius: 0;
        }

        /* Mobile dropdown adjustments */
        .dropdown-menu {
            position: static !important;
            float: none;
            width: 100%;
            margin-top: 0.5rem;
            border: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: none;
        }

        .dropdown-item {
            padding: 0.75rem 1rem;
        }
    }

    /* Desktop Styles */
    @media (min-width: 992px) {

        /* Hide mobile elements on desktop */
        .d-lg-none.order-lg-1 {
            display: none !important;
        }

        .mobile-search-container,
        #mobileSearchToggle {
            display: none !important;
        }

        /* Desktop nav adjustments */
        .navbar-nav {
            gap: 0.5rem;
        }

        .nav-link {
            padding: 0.5rem 1rem;
        }
    }

    /* Brand Gradient */
    .gradient-text {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
    }

    .brand-text {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Animated Hamburger Icon */
    .animated-icon {
        transition: var(--transition);
        font-size: 1.25rem;
    }

    .navbar-toggler:not(.collapsed) .animated-icon {
        transform: rotate(90deg);
        color: var(--secondary-color);
    }

    /* Nav Links Hover Effect */
    .nav-hover {
        position: relative;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        transition: var(--transition);
    }

    .nav-hover:hover {
        background: linear-gradient(135deg, var(--primary-color) 0%, rgba(99, 102, 241, 0.1) 100%);
        color: var(--primary-color) !important;
        transform: translateY(-1px);
    }

    .nav-hover::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        transition: var(--transition);
        transform: translateX(-50%);
    }

    .nav-hover:hover::after {
        width: 80%;
    }

    /* Dropdown Animations */
    .dropdown-animate {
        animation: slideDown 0.3s ease-out;
        border: none;
        box-shadow: var(--shadow-lg);
        border-radius: 0.75rem;
        padding: 0.5rem;
        margin-top: 0.5rem;
        border: 1px solid rgba(0, 0, 0, 0.08);
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dropdown-hover {
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        transition: var(--transition);
        display: flex;
        align-items: center;
        margin: 0.25rem 0;
    }

    .dropdown-hover:hover {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
        color: white !important;
        transform: translateX(5px);
    }

    .category-icon {
        color: var(--primary-color);
        width: 24px;
        text-align: center;
        font-size: 0.9rem;
    }

    /* Search Styling (Desktop Only) */
    .search-container {
        position: relative;
    }

    .search-form {
        background: var(--light-color);
        border-radius: 2rem;
        padding: 0.25rem;
        transition: var(--transition);
        border: 2px solid transparent;
    }

    .search-form:focus-within {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        transform: translateY(-1px);
    }

    .search-input {
        border: none;
        background: transparent;
        padding: 0.5rem 0.75rem;
        width: 200px;
        transition: var(--transition);
        font-size: 0.9rem;
    }

    .search-input:focus {
        outline: none;
        width: 240px;
    }

    .search-btn {
        background: transparent;
        border: none;
        padding: 0.5rem 1rem;
        color: var(--primary-color);
        cursor: pointer;
        transition: var(--transition);
        border-radius: 50%;
        font-size: 0.9rem;
    }

    .search-btn:hover {
        background: var(--primary-color);
        color: white;
        transform: scale(1.1);
    }

    /* Search Suggestions */
    .search-suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border-radius: 0.75rem;
        box-shadow: var(--shadow-lg);
        z-index: 1000;
        display: none;
        padding: 0.5rem;
        max-height: 300px;
        overflow-y: auto;
    }

    .search-suggestions.show {
        display: block;
        animation: slideDown 0.2s ease;
    }

    /* Floating Buttons */
    .btn-float {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        transition: var(--transition);
        border: 2px solid transparent;
        box-shadow: var(--shadow-sm);
        text-decoration: none;
    }

    .btn-float:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: var(--shadow-md);
    }

    .btn-wishlist {
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        color: var(--danger-color);
        border-color: rgba(239, 68, 68, 0.2);
    }

    .btn-wishlist:hover {
        background: var(--danger-color);
        color: white;
        border-color: var(--danger-color);
    }

    .btn-cart {
        background: linear-gradient(135deg, #eff6ff, #dbeafe);
        color: var(--primary-color);
        border-color: rgba(99, 102, 241, 0.2);
    }

    .btn-cart:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    /* Badge Count */
    .badge-count {
        position: absolute;
        top: -5px;
        right: -5px;
        background: var(--danger-color);
        color: white;
        font-size: 0.65rem;
        min-width: 18px;
        height: 18px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        animation: pulse 2s infinite;
        pointer-events: none;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }

        100% {
            transform: scale(1);
        }
    }

    /* User Dropdown */
    .rounded-border {
        border: 1px solid rgba(0, 0, 0, 0.12);
        border-radius: 30px;
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(6px);
        transition: all 0.25s ease;
    }

    .rounded-border:hover {
        border-color: rgba(0, 0, 0, 0.25);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
    }

    .user-dropdown .dropdown-toggle {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: var(--dark-color);
        padding: 0.5rem;
        border-radius: 2rem;
        transition: var(--transition);
    }

    .user-dropdown .dropdown-toggle:hover {
        background: var(--light-color);
    }

    .avatar-initials {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 0.9rem;
    }

    .user-name {
        font-weight: 500;
        font-size: 0.9rem;
    }

    /* Auth Buttons */
    .btn-hover {
        transition: var(--transition);
        border-width: 2px;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .btn-hover:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        border-color: var(--primary-hover);
        color: var(--primary-hover);
    }

    .btn-gradient {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border: none;
        color: white;
        font-weight: 500;
        transition: var(--transition);
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        background: linear-gradient(135deg, var(--primary-hover), #db2777);
        color: white;
    }

    /* Active State for Current Page */
    .nav-link.active {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-hover)) !important;
        color: white !important;
        border-radius: 0.5rem;
    }

    /* Scroll behavior for fixed navbar */
    body {
        padding-top: 76px;
        /* Adjust based on navbar height */
    }

    /* Mobile Search Toggle Button */
    #mobileSearchToggle {
        border-radius: 0.75rem;
        padding: 0.75rem;
        font-weight: 500;
        background: var(--light-color);
        border: 2px dashed var(--primary-color);
        color: var(--primary-color);
        transition: var(--transition);
    }

    #mobileSearchToggle:hover {
        background: var(--primary-color);
        color: white;
        border-style: solid;
    }

    /* Loading state for search */
    .search-loading {
        position: relative;
        color: transparent !important;
    }

    .search-loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 16px;
        height: 16px;
        margin-top: -8px;
        margin-left: -8px;
        border: 2px solid #ddd;
        border-top-color: var(--primary-color);
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* Accessibility */
    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
    }

    /* Focus styles */
    :focus-visible {
        outline: 2px solid var(--primary-color);
        outline-offset: 2px;
    }

    /* Touch device optimizations */
    @media (hover: none) and (pointer: coarse) {
        .btn-float {
            min-width: 44px;
            min-height: 44px;
        }

        .nav-link,
        .dropdown-item {
            min-height: 44px;
        }

        .search-input {
            font-size: 16px;
            /* Prevents iOS zoom */
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile Search Toggle
        const mobileSearchToggle = document.getElementById('mobileSearchToggle');
        const mobileSearchContainer = document.querySelector('.mobile-search-container');

        if (mobileSearchToggle && mobileSearchContainer) {
            mobileSearchToggle.addEventListener('click', function() {
                mobileSearchContainer.classList.toggle('d-none');
                const isVisible = !mobileSearchContainer.classList.contains('d-none');

                if (isVisible) {
                    // Focus on input when shown
                    const input = mobileSearchContainer.querySelector('input');
                    if (input) {
                        setTimeout(() => input.focus(), 100);
                    }

                    // Change button text
                    this.innerHTML = '<i class="fas fa-times me-2"></i> Close Search';
                } else {
                    this.innerHTML = '<i class="fas fa-search me-2"></i> Search Products';
                }
            });
        }

        // Update active nav link based on current page
        function setActiveNavLink() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });

            // Also check for parent routes
            const pathSegments = currentPath.split('/').filter(Boolean);
            if (pathSegments.length > 0) {
                navLinks.forEach(link => {
                    const href = link.getAttribute('href');
                    if (href && href !== '/' && currentPath.includes(href)) {
                        link.classList.add('active');
                    }
                });
            }
        }

        // Search functionality (desktop)
        const searchInput = document.querySelector('.search-input');
        const searchSuggestions = document.getElementById('searchSuggestions');

        if (searchInput && searchSuggestions) {
            let searchTimeout;

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const query = this.value.trim();

                if (query.length < 2) {
                    searchSuggestions.classList.remove('show');
                    return;
                }

                // Show loading
                searchSuggestions.innerHTML =
                    '<div class="p-3 text-center"><i class="fas fa-spinner fa-spin"></i> Searching...</div>';
                searchSuggestions.classList.add('show');

                searchTimeout = setTimeout(() => {
                    performSearch(query);
                }, 300);
            });

            // Hide suggestions when clicking outside
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !searchSuggestions.contains(e.target)) {
                    searchSuggestions.classList.remove('show');
                }
            });
        }

        // Simulate search (replace with actual API call)
        function performSearch(query) {
            // This is a mock function - replace with your actual search API
            setTimeout(() => {
                const suggestions = [{
                        name: 'Smartphone',
                        url: '/products/smartphone'
                    },
                    {
                        name: 'Laptop',
                        url: '/products/laptop'
                    },
                    {
                        name: 'Headphones',
                        url: '/products/headphones'
                    },
                    {
                        name: 'Watch',
                        url: '/products/watch'
                    }
                ].filter(item => item.name.toLowerCase().includes(query.toLowerCase()));

                if (searchSuggestions) {
                    if (suggestions.length > 0) {
                        searchSuggestions.innerHTML = suggestions.map(item => `
                            <a href="${item.url}" class="dropdown-item dropdown-hover">
                                <i class="fas fa-search me-2 text-muted"></i>
                                ${item.name}
                            </a>
                        `).join('');
                    } else {
                        searchSuggestions.innerHTML =
                            '<div class="p-3 text-center text-muted">No results found</div>';
                    }
                    searchSuggestions.classList.add('show');
                }
            }, 500);
        }

        // Update cart and wishlist counts dynamically
        function updateCartCount(count) {
            const elements = document.querySelectorAll(
                '.cart-count-badge, .cart-mobile-count, .desktop-cart-count');
            elements.forEach(el => {
                if (el) {
                    el.textContent = count;
                    el.style.display = count > 0 ? 'flex' : 'none';
                }
            });
        }

        function updateWishlistCount(count) {
            const elements = document.querySelectorAll(
                '.wishlist-count-badge, .wishlist-mobile-count, .desktop-wishlist-count');
            elements.forEach(el => {
                if (el) {
                    el.textContent = count;
                    el.style.display = count > 0 ? 'flex' : 'none';
                }
            });
        }

        // Initialize
        setActiveNavLink();

        // Listen for cart updates (from your main layout script)
        document.addEventListener('cartUpdated', function() {
            // You can fetch cart count via AJAX here
            // For now, we'll simulate it
            updateCartCount(parseInt('{{ $cartProductCount }}'));
        });

        // Listen for wishlist updates
        document.addEventListener('wishlistUpdated', function() {
            updateWishlistCount(parseInt('{{ $wishlistCount }}'));
        });

        // Mobile menu accessibility
        const navbarToggler = document.querySelector('.navbar-toggler');
        if (navbarToggler) {
            navbarToggler.addEventListener('click', function() {
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', !isExpanded);
            });
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const navbar = document.querySelector('.navbar-collapse');
            const toggler = document.querySelector('.navbar-toggler');

            if (navbar && navbar.classList.contains('show') &&
                !navbar.contains(event.target) &&
                !toggler.contains(event.target)) {
                bootstrap.Collapse.getInstance(navbar).hide();
            }
        });

        // Keyboard navigation for dropdowns
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const openDropdowns = document.querySelectorAll('.dropdown-menu.show');
                openDropdowns.forEach(dropdown => {
                    bootstrap.Dropdown.getInstance(dropdown.previousElementSibling).hide();
                });

                // Also close mobile search
                if (mobileSearchContainer && !mobileSearchContainer.classList.contains('d-none')) {
                    mobileSearchContainer.classList.add('d-none');
                    if (mobileSearchToggle) {
                        mobileSearchToggle.innerHTML =
                            '<i class="fas fa-search me-2"></i> Search Products';
                    }
                }
            }
        });
    });

    // Global functions to update counts from other scripts
    window.Navbar = {
        updateCartCount: function(count) {
            updateCartCount(count);
        },
        updateWishlistCount: function(count) {
            updateWishlistCount(count);
        }
    };
</script>
