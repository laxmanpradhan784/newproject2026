<footer class="bg-dark text-white pt-5 pb-4 mt-5">
    <div class="container">
        <div class="row">

            <!-- Company Info -->
            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="fw-bold mb-4">
                    <i class="fas fa-shopping-bag me-2"></i>E-Shop
                </h5>
                <p class="text-light">
                    Your one-stop destination for all your shopping needs. Quality products, best prices, and exceptional customer service.
                </p>
                <div class="social-icons mt-4">
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook-f fa-lg"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-linkedin-in fa-lg"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="fw-bold mb-4">Quick Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('home') }}" class="text-light text-decoration-none">Home</a></li>
                    <li class="mb-2"><a href="{{ route('products') }}" class="text-light text-decoration-none">Shop</a></li>
                    <li class="mb-2"><a href="{{ route('products') }}" class="text-light text-decoration-none">Categories</a></li>
                    <li class="mb-2"><a href="{{ route('about') }}" class="text-light text-decoration-none">About Us</a></li>
                    <li class="mb-2"><a href="{{ route('contact') }}" class="text-light text-decoration-none">Contact</a></li>
                </ul>
            </div>

            <!-- Categories -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="fw-bold mb-4">Categories</h5>
                    <ul class="list-unstyled">

                        @php
                            $footerCategories = \App\Models\Category::where('status','active')->limit(5)->get();
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
            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="fw-bold mb-4">Contact Us</h5>
                <ul class="list-unstyled">
                    <li class="mb-3">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        123 Street, City, Country
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-phone me-2"></i>
                        +1 234 567 8900
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-envelope me-2"></i>
                        info@eshop.com
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
        <div class="row">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0">&copy; {{ date('Y') }} E-Shop. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <a href="{{ route('about') }}" class="text-light text-decoration-none me-3">Privacy Policy</a>
                <a href="{{ route('about') }}" class="text-light text-decoration-none">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>
