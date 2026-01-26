<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top" style="border-bottom: 1px solid rgba(0,0,0,0.05); transition: all 0.3s ease;">
    <div class="container">
        <!-- Brand/Logo -->
        <a class="navbar-brand fw-bold" href="{{ route('home') }}" style="color: #4361ee; transition: color 0.3s ease;">
            <i class="fas fa-shopping-bag me-2" style="background: linear-gradient(45deg, #4361ee, #7209b7); 
                -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
            <span style="background: linear-gradient(45deg, #4361ee, #7209b7); 
                -webkit-background-clip: text; -webkit-text-fill-color: transparent;">E-Shop</span>
        </a>
        
        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="fas fa-bars text-primary"></i>
        </button>
        
        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item mx-1">
                    <a class="nav-link position-relative px-3 py-2 rounded-pill {{ request()->routeIs('home') ? 'active' : '' }}" 
                       href="{{ route('home') }}" 
                       style="transition: all 0.3s ease;">
                        <i class="fas fa-home me-1"></i> Home
                        @if(request()->routeIs('home'))
                        <span class="position-absolute bottom-0 start-50 translate-middle-x bg-primary" 
                              style="width: 6px; height: 6px; border-radius: 50%;"></span>
                        @endif
                    </a>
                </li>
                
                <li class="nav-item dropdown mx-1">
                    <a class="nav-link dropdown-toggle position-relative px-3 py-2 rounded-pill fw-medium" 
                       href="#" role="button" data-bs-toggle="dropdown"
                       style="transition: all 0.3s ease;">
                        <i class="fas fa-layer-group me-1"></i> Categories
                    </a>
                    <ul class="dropdown-menu shadow-lg border-0 rounded-3 p-2" style="min-width: 250px;">
                        @php
                            $allCategories = \App\Models\Category::where('status', 'active')->get();
                        @endphp

                        @forelse($allCategories as $category)
                            <li>
                                <a class="dropdown-item d-flex align-items-center py-2 px-3 rounded-2" 
                                   href="{{ route('category.products', $category->slug) }}"
                                   style="transition: all 0.2s ease;">
                                    <i class="fas fa-folder me-2 text-primary opacity-75"></i>
                                    {{ $category->name }}
                                </a>
                            </li>
                        @empty
                            <li><span class="dropdown-item text-muted">No categories found</span></li>
                        @endforelse
                    </ul>
                </li>

                <li class="nav-item mx-1">
                    <a class="nav-link position-relative px-3 py-2 rounded-pill {{ request()->routeIs('products') ? 'active' : '' }}" 
                       href="{{ route('products') }}"
                       style="transition: all 0.3s ease;">
                        <i class="fas fa-box-open me-1"></i> Products
                        @if(request()->routeIs('products'))
                        <span class="position-absolute bottom-0 start-50 translate-middle-x bg-primary" 
                              style="width: 6px; height: 6px; border-radius: 50%;"></span>
                        @endif
                    </a>
                </li>
                
                <li class="nav-item mx-1">
                    <a class="nav-link position-relative px-3 py-2 rounded-pill {{ request()->routeIs('about') ? 'active' : '' }}" 
                       href="{{ route('about') }}"
                       style="transition: all 0.3s ease;">
                        <i class="fas fa-info-circle me-1"></i> About
                        @if(request()->routeIs('about'))
                        <span class="position-absolute bottom-0 start-50 translate-middle-x bg-primary" 
                              style="width: 6px; height: 6px; border-radius: 50%;"></span>
                        @endif
                    </a>
                </li>
                
                <li class="nav-item mx-1">
                    <a class="nav-link position-relative px-3 py-2 rounded-pill {{ request()->routeIs('contact') ? 'active' : '' }}" 
                       href="{{ route('contact') }}"
                       style="transition: all 0.3s ease;">
                        <i class="fas fa-phone-alt me-1"></i> Contact
                        @if(request()->routeIs('contact'))
                        <span class="position-absolute bottom-0 start-50 translate-middle-x bg-primary" 
                              style="width: 6px; height: 6px; border-radius: 50%;"></span>
                        @endif
                    </a>
                </li>
            </ul>
            
            <!-- Right Side: Search & User -->
            <div class="d-flex align-items-center">
                <!-- Search Form -->
                <form class="d-flex me-3 position-relative" action="{{ route('product.search') }}" method="GET">
                    <div class="input-group search-group" style="transition: all 0.3s ease;">
                        <input type="text" 
                            class="form-control border-end-0 shadow-none" 
                            name="q" 
                            placeholder="Search products..." 
                            value="{{ request('q') }}" 
                            style="border-radius: 50px 0 0 50px; padding-left: 45px; transition: all 0.3s ease;"
                            onfocus="this.parentElement.style.boxShadow='0 0 0 3px rgba(67, 97, 238, 0.2)';"
                            onblur="this.parentElement.style.boxShadow='none';">
                        
                        <div class="input-group-text bg-transparent border-0 position-absolute start-0" 
                             style="z-index: 10; padding-left: 15px; margin-top:5px;">
                            <i class="fas fa-search text-muted"></i>
                        </div>

                        <button class="btn btn-primary border-0" type="submit" 
                                style="border-radius: 0 50px 50px 0; background: linear-gradient(45deg, #4361ee, #7209b7); 
                                       transition: all 0.3s ease;">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>

               <!-- Cart Icon with Count (Number of Products) -->
                <a href="{{ route('cart') }}" class="btn btn-outline-primary position-relative me-3 rounded-circle p-2"
                style="width: 40px; height: 40px; text-decoration: none;"
                title="Shopping Cart">
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
                            $cartProductCount = Cart::where(function($query) {
                                    if (session()->has('guest_token')) {
                                        $query->where('guest_token', session('guest_token'));
                                    }
                                    $query->orWhere('session_id', session()->getId());
                                })
                                ->where('is_guest', true)
                                ->count();
                        }
                    @endphp
                    
                    @if($cartProductCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-count-badge" 
                        style="font-size: 10px; padding: 3px 6px; min-width: 18px; height: 18px; display: inline-flex; align-items: center; justify-content: center;"
                        id="navbarCartCount"
                        title="{{ $cartProductCount }} item{{ $cartProductCount > 1 ? 's' : '' }} in cart">
                        {{ $cartProductCount }}
                    </span>
                    @else
                    <!-- Hidden badge for JavaScript updates -->
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-count-badge" 
                        style="font-size: 10px; padding: 3px 6px; min-width: 18px; height: 18px; display: none;"
                        id="navbarCartCount"
                        title="Cart is empty">
                        0
                    </span>
                    @endif
                </a>

                <!-- User Dropdown -->
                @auth
                    <div class="dropdown">
                        <a class="dropdown-toggle d-flex align-items-center text-decoration-none p-1 rounded-pill border" 
                           href="#" role="button" data-bs-toggle="dropdown"
                           style="border-color: #e9ecef !important; transition: all 0.3s ease;"
                           onmouseover="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)';"
                           onmouseout="this.style.boxShadow='none';">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-2" 
                                 style="width: 36px; height: 36px; background: linear-gradient(45deg, #4361ee, #7209b7);">
                                <span class="text-white fw-medium" style="font-size: 14px;">
                                    {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}
                                </span>
                            </div>
                            <span class="me-2 text-dark fw-medium">{{ Auth::user()->first_name }}</span>
                            <i class="fas fa-chevron-down text-muted" style="font-size: 12px;"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 p-2 mt-2" 
                            style="min-width: 220px;">
                            <li>
                                <a class="dropdown-item d-flex align-items-center py-2 px-3 rounded-2" 
                                   href="{{ route('profile') }}"
                                   style="transition: all 0.2s ease;">
                                    <i class="fas fa-user me-3 text-primary"></i>
                                    <span>Profile</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center py-2 px-3 rounded-2" 
                                   href="{{ route('orders') }}"
                                   style="transition: all 0.2s ease;">
                                    <i class="fas fa-shopping-bag me-3 text-primary"></i>
                                    <span>Orders</span>
                                </a>
                            </li>
                            {{-- <li>
                                <a class="dropdown-item d-flex align-items-center py-2 px-3 rounded-2" 
                                   href="{{ route('wishlist') }}"
                                   style="transition: all 0.2s ease;">
                                    <i class="fas fa-heart me-3 text-primary"></i>
                                    <span>Wishlist</span>
                                </a>
                            </li> --}}
                            <li><hr class="dropdown-divider my-2"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item d-flex align-items-center py-2 px-3 rounded-2 w-100"
                                            style="transition: all 0.2s ease; border: none; background: transparent;">
                                        <i class="fas fa-sign-out-alt me-3 text-danger"></i>
                                        <span class="text-danger">Logout</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth
                
                @guest
                    <div class="d-flex">
                        <a href="{{ route('login') }}" 
                           class="btn btn-outline-primary me-2 rounded-pill px-4"
                           style="transition: all 0.3s ease;">
                            Login
                        </a>
                        <a href="{{ route('register') }}" 
                           class="btn btn-primary rounded-pill px-4"
                           style="background: linear-gradient(45deg, #4361ee, #7209b7); 
                                  border: none; transition: all 0.3s ease;">
                            Register
                        </a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Search Bar -->
<div class="d-lg-none container mt-3 mb-3 animate__animated animate__fadeIn">
    <form action="{{ route('product.search') }}" method="GET">
        <div class="input-group shadow-sm">
            <input type="text" 
                   class="form-control border-end-0" 
                   name="q" 
                   placeholder="Search products..." 
                   value="{{ request('q') }}"
                   style="border-radius: 50px 0 0 50px;">
            <button class="btn btn-primary border-0" 
                    type="submit"
                    style="border-radius: 0 50px 50px 0; background: linear-gradient(45deg, #4361ee, #7209b7);">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>
</div>

<!-- Add some CSS for hover effects -->
<style>
    .nav-link:hover {
        background-color: rgba(67, 97, 238, 0.05) !important;
        transform: translateY(-1px);
    }
    
    .nav-link.active {
        background-color: rgba(67, 97, 238, 0.1) !important;
        color: #4361ee !important;
        font-weight: 500;
    }
    
    .dropdown-item:hover {
        background-color: rgba(67, 97, 238, 0.08) !important;
        transform: translateX(5px);
    }
    
    .search-group:focus-within {
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        border-radius: 50px;
    }
    
    .navbar {
        backdrop-filter: blur(10px);
        background-color: rgba(255, 255, 255, 0.95);
    }
</style>