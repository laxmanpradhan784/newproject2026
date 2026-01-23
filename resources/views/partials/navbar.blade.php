<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
    <div class="container">
        <!-- Brand/Logo -->
        <a class="navbar-brand fw-bold text-primary" href="{{ route('home') }}">
            <i class="fas fa-shopping-bag me-2"></i>E-Shop
        </a>
        
        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active fw-bold' : '' }}" href="{{ route('home') }}">
                        <i class="fas fa-home me-1"></i> Home
                    </a>
                </li>
                
                 <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-bold" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-list me-1"></i> Categories
                    </a>
                    <ul class="dropdown-menu">
                        @php
                            $allCategories = \App\Models\Category::where('status', 'active')->get();
                        @endphp

                        @forelse($allCategories as $category)
                            <li>
                                <a class="dropdown-item" href="{{ route('category.products', $category->slug) }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @empty
                            <li><span class="dropdown-item text-muted">No categories found</span></li>
                        @endforelse
                    </ul>
                </li>


                <li class="nav-item">
                    <a class="nav-link fw-bold {{ request()->routeIs('products') ? 'active' : '' }}" 
                    href="{{ route('products') }}">
                        <i class="fas fa-box me-1"></i> Products
                    </a>
                </li>

                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active fw-bold' : '' }}" href="{{ route('about') }}">
                        <i class="fas fa-info-circle me-1"></i> About
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active fw-bold' : '' }}" href="{{ route('contact') }}">
                        <i class="fas fa-phone me-1"></i> Contact
                    </a>
                </li>
            </ul>
            
            <!-- Right Side: Search & User -->
            <div class="d-flex align-items-center">
                <!-- Search Form -->
                <form class="d-flex me-3" action="{{ route('product.search') }}" method="GET">
                    <div class="input-group">
                        <input type="text" 
                            class="form-control" 
                            name="q" 
                            placeholder="Search products..." 
                            value="{{ request('q') }}" 
                            style="border-radius: 20px 0 0 20px;">

                        <button class="btn btn-primary" type="submit" style="border-radius: 0 20px 20px 0;">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>

                
                <!-- Static Cart Button -->
                    <a href="#" class="btn btn-primary position-relative me-3">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            0
                        </span>
                    </a>

                
                <!-- User Dropdown -->
                @auth
                    <div class="dropdown">
                        <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" 
                                 style="width: 40px; height: 40px; background: linear-gradient(45deg, #4361ee, #7209b7);">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <span class="ms-2">{{ Auth::user()->first_name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="fas fa-user me-2"></i> Profile
                                </a>
                            </li>

                            <li><a class="dropdown-item" href="{{ route('orders') }}"><i class="fas fa-shopping-bag me-2"></i> Orders</a></li>
                            <li><a class="dropdown-item" href="{{ route('wishlist') }}"><i class="fas fa-heart me-2"></i> Wishlist</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth
                
                @guest
                    <div class="d-flex">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Search Bar (Hidden on desktop) -->
<div class="d-lg-none container mt-2">
    <form action="{{ route('product.search') }}" method="GET">
        <div class="input-group">
            <input type="text" class="form-control" name="q" placeholder="Search products..." value="{{ request('q') }}">
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>
</div>
