<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/favicon.png') }}">

    <!-- Preconnect for faster font loading -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- External CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @stack('styles')
    
    <style>
        body {
            background-color: #f5f7fa;
            background-image: linear-gradient(135deg, #f5f7fa 0%, #ced3da 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        
        main {
            flex: 1;
            padding-top: 30px;
            padding-bottom: 30px;
            animation: fadeIn 0.5s ease-in;
        }
        
        /* Accessibility focus styles */
        :focus {
            /* outline: 3px solid rgba(77, 144, 254, 0.6) !important; */
            outline-offset: 3px;
            border-radius: 3px;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        /* Loading animation */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 0.8s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            body {
                font-size: 15px;
            }
            
            main {
                padding-top: 20px;
                padding-bottom: 20px;
            }
        }
        
        @media (max-width: 576px) {
            body {
                font-size: 14px;
            }
            
            .container, .container-fluid {
                padding-left: 15px;
                padding-right: 15px;
            }
        }
        
        /* Touch device optimizations */
        @media (hover: none) and (pointer: coarse) {
            .btn, 
            .form-control,
            .nav-link,
            .dropdown-item {
                min-height: 44px;
                padding-top: 12px;
                padding-bottom: 12px;
            }
            
            /* Better touch feedback */
            .btn:active,
            .nav-link:active {
                transform: scale(0.97);
                transition: transform 0.1s;
            }
            
            /* Prevent accidental taps */
            .btn {
                touch-action: manipulation;
            }
        }
        
        /* Print styles */
        @media print {
            .no-print,
            .navbar,
            .footer,
            #backToTop,
            #toastContainer {
                display: none !important;
            }
            
            body {
                background: white !important;
                color: black !important;
            }
            
            a {
                color: black !important;
                text-decoration: underline !important;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    @include('partials.navbar')

    <!-- Main Content -->
    <main class="container-fluid">
        <!-- Page Content -->
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Toast Container for Notifications -->
    <div id="toastContainer" class="position-fixed" style="
        z-index: 99999;
        bottom: 20px;
        right: 20px;
        left: 20px;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    "></div>

    <!-- Cart Session Data (for JavaScript) -->
    @if (!auth()->check() && session()->has('guest_token'))
        <div id="cartSessionData" data-guest-token="{{ session('guest_token') }}"
            data-session-id="{{ session()->getId() }}" style="display: none;">
        </div>
    @endif

    <!-- External JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom JavaScript -->
    <script src="{{ asset('js/script.js') }}"></script>

    <!-- Enhanced UI & Responsiveness Script -->
    <script>
        // DOM Ready function
        document.addEventListener('DOMContentLoaded', function() {
            initializeCart();
            initializeUIEnhancements();
            setupAccessibilityFeatures();
            setupResponsiveBehaviors();
        });

        // ==================== UI ENHANCEMENTS ====================
        function initializeUIEnhancements() {
            // Add back to top button
            addBackToTopButton();
            
            // Setup smooth scrolling
            setupSmoothScrolling();
            
            // Setup loading states
            setupLoadingStates();
            
            // Setup responsive tables
            setupResponsiveTables();
            
            // Setup image lazy loading
            setupLazyLoading();
        }

        // Add back to top button
        function addBackToTopButton() {
            const backToTop = document.createElement('button');
            backToTop.innerHTML = '<i class="fas fa-chevron-up"></i>';
            backToTop.className = 'btn btn-primary rounded-circle position-fixed shadow-lg';
            backToTop.id = 'backToTop';
            backToTop.setAttribute('aria-label', 'Back to top');
            backToTop.style.cssText = `
                bottom: 80px;
                right: 20px;
                width: 56px;
                height: 56px;
                display: none;
                z-index: 1000;
                opacity: 0.9;
                transition: all 0.3s ease;
            `;
            
            backToTop.addEventListener('mouseenter', () => {
                backToTop.style.opacity = '1';
                backToTop.style.transform = 'scale(1.1)';
            });
            
            backToTop.addEventListener('mouseleave', () => {
                backToTop.style.opacity = '0.9';
                backToTop.style.transform = 'scale(1)';
            });
            
            backToTop.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
            
            document.body.appendChild(backToTop);
            
            // Show/hide based on scroll
            window.addEventListener('scroll', () => {
                backToTop.style.display = window.scrollY > 300 ? 'block' : 'none';
            });
        }

        // Smooth scrolling for anchor links
        function setupSmoothScrolling() {
            document.querySelectorAll('a[href^="#"]:not([href="#"])').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    const target = document.querySelector(targetId);
                    
                    if (target) {
                        const headerOffset = 80;
                        const elementPosition = target.getBoundingClientRect().top;
                        const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                        
                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });
                        
                        // Focus for accessibility
                        target.setAttribute('tabindex', '-1');
                        target.focus();
                    }
                });
            });
        }

        // Setup loading states for buttons
        function setupLoadingStates() {
            document.addEventListener('click', function(e) {
                if (e.target.matches('.btn[data-loading], .btn-loading')) {
                    const btn = e.target;
                    if (!btn.disabled) {
                        btn.classList.add('btn-loading');
                        btn.disabled = true;
                        
                        // Auto remove loading state after 5 seconds (safety)
                        setTimeout(() => {
                            btn.classList.remove('btn-loading');
                            btn.disabled = false;
                        }, 5000);
                    }
                }
            });
        }

        // Make tables responsive
        function setupResponsiveTables() {
            document.querySelectorAll('table:not(.table-responsive)').forEach(table => {
                if (table.offsetWidth > window.innerWidth * 0.9) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'table-responsive';
                    table.parentNode.insertBefore(wrapper, table);
                    wrapper.appendChild(table);
                }
            });
        }

        // Lazy loading for images
        function setupLazyLoading() {
            const images = document.querySelectorAll('img[data-src]');
            
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                        img.classList.add('fade-in');
                        observer.unobserve(img);
                    }
                });
            });
            
            images.forEach(img => imageObserver.observe(img));
        }

        // ==================== ACCESSIBILITY ====================
        function setupAccessibilityFeatures() {
            // Skip to content link
            addSkipToContentLink();
            
            // Trap focus in modals
            setupModalFocusTrap();
            
            // ARIA live regions for dynamic content
            setupAriaLiveRegions();
        }

        function addSkipToContentLink() {
            const skipLink = document.createElement('a');
            skipLink.href = '#main-content';
            skipLink.className = 'skip-to-content visually-hidden-focusable';
            skipLink.innerHTML = 'Skip to main content';
            skipLink.style.cssText = `
                position: absolute;
                top: -40px;
                left: 10px;
                background: #007bff;
                color: white;
                padding: 10px;
                z-index: 9999;
                text-decoration: none;
                border-radius: 4px;
            `;
            
            document.body.insertBefore(skipLink, document.body.firstChild);
            
            // Add id to main content if not exists
            if (!document.querySelector('main#main-content')) {
                document.querySelector('main').id = 'main-content';
            }
        }

        function setupModalFocusTrap() {
            document.addEventListener('shown.bs.modal', function(e) {
                const modal = e.target;
                const focusable = modal.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
                const firstFocusable = focusable[0];
                const lastFocusable = focusable[focusable.length - 1];
                
                if (firstFocusable) firstFocusable.focus();
                
                modal.addEventListener('keydown', function(e) {
                    if (e.key === 'Tab') {
                        if (e.shiftKey) {
                            if (document.activeElement === firstFocusable) {
                                e.preventDefault();
                                lastFocusable.focus();
                            }
                        } else {
                            if (document.activeElement === lastFocusable) {
                                e.preventDefault();
                                firstFocusable.focus();
                            }
                        }
                    }
                    if (e.key === 'Escape') {
                        bootstrap.Modal.getInstance(modal).hide();
                    }
                });
            });
        }

        function setupAriaLiveRegions() {
            // Add aria-live region for dynamic updates
            const liveRegion = document.createElement('div');
            liveRegion.className = 'sr-only';
            liveRegion.setAttribute('aria-live', 'polite');
            liveRegion.setAttribute('aria-atomic', 'true');
            liveRegion.id = 'ariaLiveRegion';
            document.body.appendChild(liveRegion);
        }

        // ==================== RESPONSIVE BEHAVIORS ====================
        function setupResponsiveBehaviors() {
            // Handle window resize
            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                document.body.classList.add('resizing');
                resizeTimer = setTimeout(() => {
                    document.body.classList.remove('resizing');
                    handleResponsiveChanges();
                }, 250);
            });
            
            // Touch vs hover detection
            setupTouchDetection();
        }

        function handleResponsiveChanges() {
            // Adjust toast position on mobile
            if (window.innerWidth < 768) {
                document.getElementById('toastContainer').style.cssText = `
                    bottom: 10px;
                    right: 10px;
                    left: 10px;
                    max-width: 100%;
                `;
            } else {
                document.getElementById('toastContainer').style.cssText = `
                    bottom: 20px;
                    right: 20px;
                    left: 20px;
                    max-width: 400px;
                    margin-left: auto;
                    margin-right: auto;
                `;
            }
            
            // Re-check responsive tables
            setupResponsiveTables();
        }

        function setupTouchDetection() {
            // Add touch class to body if touch device
            if ('ontouchstart' in window || navigator.maxTouchPoints) {
                document.body.classList.add('touch-device');
            } else {
                document.body.classList.add('no-touch-device');
            }
        }

        // ==================== ENHANCED CART FUNCTIONS ====================
        // [Keep all your existing cart functions here - they remain unchanged]
        // Just copy all your existing cart functions starting from line 73 in your original code
        
        // Cart functionality for guest and logged-in users
        document.addEventListener('DOMContentLoaded', function() {
            initializeCart();
        });

        // Initialize cart functionality
        function initializeCart() {
            updateCartCount();
            document.addEventListener('cartUpdated', updateCartCount);
            setupCartEventListeners();
        }

        // [Continue with all your existing cart functions...]
        // ... (Copy all your existing cart JavaScript here exactly as it was)

        // Global cart functions
        window.Cart = {
            updateCount: updateCartCount,
            add: addToCart,
            remove: removeFromCart,
            clear: clearCart,
            showToast: showToast
        };

        // ==================== ENHANCED TOAST FUNCTION ====================
        function showToast(type, message, duration = 3000) {
            const toastContainer = document.getElementById('toastContainer');
            const toast = createToastElement(type, message, duration);
            
            // Animation for mobile
            if (window.innerWidth < 768) {
                toast.style.animation = 'slideIn 0.3s ease forwards';
            }
            
            toastContainer.appendChild(toast);
            initializeToast(toast, duration);
            
            // Announce to screen readers
            announceToScreenReader(message);
        }

        function announceToScreenReader(message) {
            const liveRegion = document.getElementById('ariaLiveRegion');
            if (liveRegion) {
                liveRegion.textContent = message;
                setTimeout(() => {
                    liveRegion.textContent = '';
                }, 1000);
            }
        }

        // ==================== ERROR HANDLING ====================
        window.addEventListener('error', function(e) {
            console.error('JavaScript Error:', e.error);
            // Show user-friendly error message
            if (e.message && e.message.includes('Cart')) {
                showToast('error', 'There was an issue with your cart. Please refresh the page.');
            }
        });

        // ==================== OFFLINE DETECTION ====================
        window.addEventListener('online', function() {
            showToast('success', 'You are back online!', 2000);
            // Try to sync any pending actions
            if (window.Cart && window.Cart.updateCount) {
                window.Cart.updateCount();
            }
        });

        window.addEventListener('offline', function() {
            showToast('warning', 'You are offline. Some features may not work.', 4000);
        });
    </script>

    <!-- Progressive Web App enhancements -->
    <script>
        // Service Worker registration (optional)
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js').then(function(registration) {
                    console.log('ServiceWorker registration successful');
                }, function(err) {
                    console.log('ServiceWorker registration failed: ', err);
                });
            });
        }

        // Add to Home Screen prompt
        let deferredPrompt;
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            
            // Show install button if not already installed
            if (!window.matchMedia('(display-mode: standalone)').matches) {
                setTimeout(() => {
                    showInstallPrompt();
                }, 10000); // Show after 10 seconds
            }
        });

        function showInstallPrompt() {
            if (deferredPrompt) {
                const installBtn = document.createElement('button');
                installBtn.innerHTML = '<i class="fas fa-download me-2"></i> Install App';
                installBtn.className = 'btn btn-success position-fixed shadow';
                installBtn.style.cssText = `
                    bottom: 150px;
                    right: 20px;
                    z-index: 999;
                    animation: pulse 2s infinite;
                `;
                
                installBtn.addEventListener('click', async () => {
                    deferredPrompt.prompt();
                    const { outcome } = await deferredPrompt.userChoice;
                    if (outcome === 'accepted') {
                        installBtn.remove();
                    }
                    deferredPrompt = null;
                });
                
                document.body.appendChild(installBtn);
                
                // Auto hide after 30 seconds
                setTimeout(() => {
                    if (installBtn.parentNode) {
                        installBtn.remove();
                    }
                }, 30000);
            }
        }
    </script>

    @stack('scripts')
</body>

</html>