<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/favicon.png') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Animate.css for smooth animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- SweetAlert2 for beautiful alerts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @stack('styles')

</head>

<body>
    <!-- Cart Merge Notification -->
    @if (session('cart_merged_message'))
        <div class="alert alert-success alert-dismissible fade show mb-0 rounded-0" role="alert"
            style="border-left: 5px solid #198754;">
            <div class="container">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-3 fa-lg"></i>
                    <div class="flex-grow-1">
                        <strong>Success!</strong> {{ session('cart_merged_message') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif


    @auth
        <li>
            <hr class="dropdown-divider">
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('reviews.my') }}">
                <i class="fas fa-star me-2"></i> My Reviews
            </a>
        </li>
    @endauth



    <!-- Navigation -->
    @include('partials.navbar')

    <!-- Main Content -->
    <main>

        <div class="alert-container position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999;">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow-lg slide-down-alert"
                    role="alert" data-autohide="3000">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div class="flex-grow-1">{{ session('success') }}</div>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center shadow-lg slide-down-alert"
                    role="alert" data-autohide="3000">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <div class="flex-grow-1">{{ session('error') }}</div>
                </div>
            @endif
        </div>

        <style>
            .slide-down-alert {
                animation: slideDown 0.5s ease-out forwards;
                transform-origin: top center;
                min-width: 300px;
                max-width: 500px;
            }

            @keyframes slideDown {
                0% {
                    opacity: 0;
                    transform: translateY(-100%) scale(0.9);
                }

                70% {
                    transform: translateY(10%) scale(1.02);
                }

                100% {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }

            .alert-container {
                pointer-events: none;
            }

            .alert-container .alert {
                pointer-events: auto;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const alerts = document.querySelectorAll('.slide-down-alert');

                alerts.forEach(alert => {
                    const dismissTime = alert.getAttribute('data-autohide') || 3000;

                    // Auto dismiss after specified time
                    const timeout = setTimeout(() => {
                        // Add fade out animation
                        alert.style.animation = 'slideUp 0.5s ease-in forwards';

                        // Create slideUp animation if not exists
                        if (!document.querySelector('#slideUpAnimation')) {
                            const style = document.createElement('style');
                            style.id = 'slideUpAnimation';
                            style.textContent = `
                    @keyframes slideUp {
                        0% {
                            opacity: 1;
                            transform: translateY(0) scale(1);
                        }
                        100% {
                            opacity: 0;
                            transform: translateY(-100%) scale(0.9);
                        }
                    }
                `;
                            document.head.appendChild(style);
                        }

                        // Remove element after animation
                        setTimeout(() => {
                            if (alert.parentNode) {
                                alert.parentNode.removeChild(alert);
                            }
                        }, 500);

                    }, parseInt(dismissTime));

                    // Clear timeout if manually closed
                    const closeBtn = alert.querySelector('.btn-close');
                    if (closeBtn) {
                        closeBtn.addEventListener('click', () => {
                            clearTimeout(timeout);
                        });
                    }
                });
            });
        </script>

        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/script.js') }}"></script>

    <!-- Toast Container for Notifications -->
    <div id="toastContainer" class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055;"></div>

    <!-- Cart Session Data (for JavaScript) -->
    @if (!auth()->check() && session()->has('guest_token'))
        <div id="cartSessionData" data-guest-token="{{ session('guest_token') }}"
            data-session-id="{{ session()->getId() }}" style="display: none;">
        </div>
    @endif

    <!-- Cart Functionality JavaScript -->
    <script>
        // Cart functionality for guest and logged-in users
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize cart count
            updateCartCount();

            // Listen for cart updates
            document.addEventListener('cartUpdated', updateCartCount);

            // Add to cart functionality (for product pages)
            document.querySelectorAll('.add-to-cart-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = this.dataset.productId;
                    const quantity = this.dataset.quantity || 1;

                    addToCart(productId, quantity, this);
                });
            });

            // Quick add to cart buttons
            document.querySelectorAll('.quick-add-to-cart').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    if (form) {
                        const formData = new FormData(form);
                        const productId = formData.get('product_id');
                        const quantity = formData.get('quantity') || 1;

                        addToCart(productId, quantity, this);
                    }
                });
            });
        });

        // Update cart count in navbar
        async function updateCartCount() {
            try {
                const response = await fetch('/cart/count', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (response.ok) {
                    const data = await response.json();
                    const count = data.count || 0;

                    // Update all cart count elements
                    document.querySelectorAll('[data-cart-count], #navbarCartCount, .cart-count-badge').forEach(el => {
                        el.textContent = count;
                        if (count > 0) {
                            el.style.display = 'inline-block';
                        } else {
                            el.style.display = 'none';
                        }
                    });

                    // Dispatch event for other components
                    document.dispatchEvent(new CustomEvent('cartCountUpdated', {
                        detail: {
                            count: count
                        }
                    }));
                }
            } catch (error) {
                console.error('Error updating cart count:', error);
            }
        }

        // Add item to cart
        async function addToCart(productId, quantity = 1, button = null) {
            if (button) {
                button.disabled = true;
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
            }

            try {
                const response = await fetch(`/cart/add/${productId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        quantity: quantity
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    // Show success toast
                    showToast('success', data.message || 'Added to cart!');

                    // Update cart count
                    updateCartCount();

                    // Dispatch cart updated event
                    document.dispatchEvent(new Event('cartUpdated'));

                } else {
                    // Show error
                    showToast('error', data.message || 'Failed to add to cart');
                }

            } catch (error) {
                console.error('Error adding to cart:', error);
                showToast('error', 'Network error. Please try again.');
            } finally {
                if (button) {
                    button.disabled = false;
                    button.innerHTML = originalText;
                }
            }
        }

        // Remove item from cart
        async function removeFromCart(cartId) {
            Swal.fire({
                title: 'Remove Item',
                text: 'Are you sure you want to remove this item from your cart?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const response = await fetch(`/cart/${cartId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content,
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        const data = await response.json();

                        if (response.ok) {
                            showToast('success', data.message || 'Item removed from cart');
                            updateCartCount();
                            document.dispatchEvent(new Event('cartUpdated'));

                            // If on cart page, reload after a delay
                            if (window.location.pathname.includes('/cart')) {
                                setTimeout(() => window.location.reload(), 1000);
                            }
                        } else {
                            showToast('error', data.message || 'Failed to remove item');
                        }
                    } catch (error) {
                        console.error('Error removing from cart:', error);
                        showToast('error', 'Network error. Please try again.');
                    }
                }
            });
        }

        // Clear entire cart
        function clearCart() {
            Swal.fire({
                title: 'Clear Cart',
                text: 'Are you sure you want to remove all items from your cart?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, clear cart!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const response = await fetch('/cart/clear', {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content,
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        const data = await response.json();

                        if (response.ok) {
                            showToast('success', data.message || 'Cart cleared successfully');
                            updateCartCount();
                            document.dispatchEvent(new Event('cartUpdated'));

                            // If on cart page, reload after a delay
                            if (window.location.pathname.includes('/cart')) {
                                setTimeout(() => window.location.reload(), 1000);
                            }
                        } else {
                            showToast('error', data.message || 'Failed to clear cart');
                        }
                    } catch (error) {
                        console.error('Error clearing cart:', error);
                        showToast('error', 'Network error. Please try again.');
                    }
                }
            });
        }

        // Show toast notification
        function showToast(type, message) {
            const toastContainer = document.getElementById('toastContainer');

            // Create toast element
            const toast = document.createElement('div');
            toast.className =
                `toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} border-0`;
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');

            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;

            toastContainer.appendChild(toast);

            // Initialize and show toast
            const bsToast = new bootstrap.Toast(toast, {
                autohide: true,
                delay: 3000
            });
            bsToast.show();

            // Remove toast after it's hidden
            toast.addEventListener('hidden.bs.toast', function() {
                toast.remove();
            });
        }

        // Check if user is guest and has cart items
        function checkGuestCart() {
            const cartSessionData = document.getElementById('cartSessionData');
            if (cartSessionData) {
                const guestToken = cartSessionData.dataset.guestToken;
                if (guestToken) {
                    // You could check local storage or make an API call here
                    console.log('Guest user with token:', guestToken);
                }
            }
        }

        // Initialize on page load
        checkGuestCart();

        // Global cart functions
        window.Cart = {
            updateCount: updateCartCount,
            add: addToCart,
            remove: removeFromCart,
            clear: clearCart,
            showToast: showToast
        };
    </script>

    @stack('scripts')
</body>

</html>
