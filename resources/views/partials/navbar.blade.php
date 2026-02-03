<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top"
    style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);">
    <div class="container">

        <!-- Brand with gradient -->
        <a class="navbar-brand fw-bold gradient-text" href="{{ route('home') }}">
            <i class="fas fa-shopping-bag me-2"></i> E-Shop
        </a>

        <!-- Toggle -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="fas fa-bars text-primary animated-icon"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="d-flex w-100 align-items-center">

                <!-- CENTER MENU -->
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link nav-hover" href="{{ route('home') }}">
                            <i class="fas fa-home me-1 d-lg-none"></i> Home
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle nav-hover" data-bs-toggle="dropdown">
                            <i class="fas fa-th-large me-1 d-lg-none"></i> Categories
                        </a>
                        <ul class="dropdown-menu dropdown-animate">
                            @foreach (\App\Models\Category::where('status', 'active')->get() as $cat)
                                <li>
                                    <a class="dropdown-item dropdown-hover"
                                        href="{{ route('category.products', $cat->slug) }}">
                                        <span class="category-icon me-2">
                                            <i class="fas fa-{{ $cat->icon ?? 'tag' }}"></i>
                                        </span>
                                        {{ $cat->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-hover" href="{{ route('products') }}">
                            <i class="fas fa-box me-1 d-lg-none"></i> Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-hover" href="{{ route('about') }}">
                            <i class="fas fa-info-circle me-1 d-lg-none"></i> About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-hover" href="{{ route('contact') }}">
                            <i class="fas fa-envelope me-1 d-lg-none"></i> Contact
                        </a>
                    </li>
                </ul>

                <!-- RIGHT SIDE -->
                <div class="d-flex align-items-center ms-auto nav-right">

                    <!-- Search with animation -->
                    <div class="search-container me-3">
                        <form class="d-flex search-form" action="{{ route('product.search') }}">
                            <button class="search-btn" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <input class="search-input" type="search" placeholder="Search products...">
                        </form>
                    </div>

                    <!-- Wishlist Icon with Count (Number of Products) -->
                    <a class="btn btn-float btn-wishlist me-2" href="{{ route('wishlist.index') }}">
                        <i class="fas fa-heart"></i>

                        @php
                            use App\Models\Wishlist;

                            if (auth()->check()) {
                                // For logged-in users: count from database
                                $wishlistCount = Wishlist::where('user_id', auth()->id())->count();
                            } else {
                                // For guest users: count from session
                                $wishlistCount = count(session()->get('wishlist', []));
                            }
                        @endphp

                        @if ($wishlistCount > 0)
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger wishlist-count-badge"
                                style="font-size: 10px; padding: 3px 6px; min-width: 18px; height: 18px; display: inline-flex; align-items: center; justify-content: center;"
                                id="navbarWishlistCount"
                                title="{{ $wishlistCount }} item{{ $wishlistCount > 1 ? 's' : '' }} in wishlist">
                                {{ $wishlistCount }}
                            </span>
                        @else
                            <!-- Hidden badge for JavaScript updates -->
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger wishlist-count-badge"
                                style="font-size: 10px; padding: 3px 6px; min-width: 18px; height: 18px; display: none;"
                                id="navbarWishlistCount" title="Wishlist is empty">
                                0
                            </span>
                        @endif
                    </a>


                    <!-- Cart Icon with Count (Number of Products) -->
                    <a class="btn btn-float btn-cart me-3" href="{{ route('cart') }}">
                        <i class="fas fa-shopping-cart"></i>

                        <!-- Cart Count Badge (Number of Products) -->
                        @php
                            use App\Models\Cart;

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

                        @if ($cartProductCount > 0)
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-count-badge"
                                style="font-size: 10px; padding: 3px 6px; min-width: 18px; height: 18px; display: inline-flex; align-items: center; justify-content: center;"
                                id="navbarCartCount"
                                title="{{ $cartProductCount }} item{{ $cartProductCount > 1 ? 's' : '' }} in cart">
                                {{ $cartProductCount }}
                            </span>
                        @else
                            <!-- Hidden badge for JavaScript updates -->
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-count-badge"
                                style="font-size: 10px; padding: 3px 6px; min-width: 18px; height: 18px; display: none;"
                                id="navbarCartCount" title="Cart is empty">
                                0
                            </span>
                        @endif
                    </a>

                    @auth
                        <!-- User with avatar -->
                        <div class="dropdown user-dropdown rounded-border">
                            <a class="dropdown-toggle user-avatar" data-bs-toggle="dropdown">
                                <div class="avatar-initials">
                                    {{ substr(Auth::user()->first_name, 0, 1) }}{{ substr(Auth::user()->last_name ?? '', 0, 1) }}
                                </div>
                                <span class="user-name ms-2">{{ Auth::user()->first_name }}</span>
                                <i class="fas fa-chevron-down ms-1"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-animate">
                                <li>
                                    <a class="dropdown-item dropdown-hover" href="{{ route('profile') }}">
                                        <i class="fas fa-user me-2"></i> Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item dropdown-hover" href="{{ route('orders') }}">
                                        <i class="fas fa-user me-2"></i> My Orders
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item dropdown-hover" href="{{ route('reviews.my') }}">
                                        <i class="fas fa-user me-2"></i> My Reviews
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item dropdown-hover text-danger">
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

  .rounded-border {
    border: 1px solid rgba(0, 0, 0, 0.12);   /* soft invisible border */
    border-radius: 30px;
    background: rgba(255, 255, 255, 0.6);   /* light glass effect */
    backdrop-filter: blur(6px);
    transition: all 0.25s ease;
}

.rounded-border:hover {
    border-color: rgba(0, 0, 0, 0.25);       /* visible on hover */
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
}



    /* Brand Gradient */
    .gradient-text {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 1.5rem;
    }

    /* Animated Hamburger Icon */
    .animated-icon {
        transition: var(--transition);
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
    }

    /* Search Styling */
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
    }

    .search-btn:hover {
        background: var(--primary-color);
        color: white;
        transform: scale(1.1);
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
        font-size: 0.7rem;
        min-width: 18px;
        height: 18px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        animation: pulse 2s infinite;
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
    }

    /* Auth Buttons */
    .btn-hover {
        transition: var(--transition);
        border-width: 2px;
        font-weight: 500;
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

    /* Responsive */
    @media (max-width: 992px) {
        .nav-right {
            min-width: auto;
            margin-top: 1rem;
            justify-content: center;
            width: 100%;
        }

        .search-input:focus {
            width: 200px;
        }

        .navbar-nav {
            text-align: center;
            margin: 1rem 0;
        }

        .nav-hover {
            justify-content: center;
        }

        .auth-buttons {
            display: flex;
            gap: 0.5rem;
        }
    }

    /* Active State for Current Page */
    .nav-link.active {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-hover)) !important;
        color: white !important;
        border-radius: 0.5rem;
    }
</style>

<script>
    // Add active class to current page nav item
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.nav-link');

        navLinks.forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            }
        });

        // Optional: Add cart and wishlist count from localStorage or API
        updateCartCount();
        updateWishlistCount();
    });

    function updateCartCount() {
        // Replace with your actual cart count logic
        const cartCount = localStorage.getItem('cartCount') || 0;
        document.querySelector('.cart-count').textContent = cartCount;
    }

    function updateWishlistCount() {
        // Replace with your actual wishlist count logic
        const wishlistCount = localStorage.getItem('wishlistCount') || 0;
        document.querySelector('.wishlist-count').textContent = wishlistCount;
    }
</script>
