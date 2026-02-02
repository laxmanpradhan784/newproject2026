<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/favicon.png') }}">

    <!-- External CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @stack('styles')
</head>

<body>
    <style>
        body {
            background-color: #ced3da;
        }
    </style>
    <!-- Navigation -->
    @include('partials.navbar')

    <!-- Main Content -->
    <main>
        <!-- Page Content -->
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    <!-- External JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom JavaScript -->
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
            initializeCart();
        });

        // Initialize cart functionality
        function initializeCart() {
            updateCartCount();
            document.addEventListener('cartUpdated', updateCartCount);
            setupCartEventListeners();
        }

        // Set up cart event listeners
        function setupCartEventListeners() {
            // Add to cart buttons
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
        }

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
                    updateCartCountElements(count);
                    dispatchCartCountEvent(count);
                }
            } catch (error) {
                console.error('Error updating cart count:', error);
            }
        }

        // Update all cart count elements
        function updateCartCountElements(count) {
            document.querySelectorAll('[data-cart-count], #navbarCartCount, .cart-count-badge').forEach(el => {
                el.textContent = count;
                el.style.display = count > 0 ? 'inline-block' : 'none';
            });
        }

        // Dispatch cart count updated event
        function dispatchCartCountEvent(count) {
            document.dispatchEvent(new CustomEvent('cartCountUpdated', {
                detail: {
                    count: count
                }
            }));
        }

        // Add item to cart
        async function addToCart(productId, quantity = 1, button = null) {
            const originalButtonState = prepareButtonForRequest(button);

            try {
                const response = await fetch(`/cart/add/${productId}`, {
                    method: 'POST',
                    headers: getRequestHeaders(),
                    body: JSON.stringify({
                        quantity: quantity
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    handleAddToCartSuccess(data);
                } else {
                    handleAddToCartError(data);
                }
            } catch (error) {
                handleNetworkError(error);
            } finally {
                restoreButtonState(button, originalButtonState);
            }
        }

        // Prepare button for API request
        function prepareButtonForRequest(button) {
            if (!button) return null;

            const originalText = button.innerHTML;
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';

            return originalText;
        }

        // Restore button state after request
        function restoreButtonState(button, originalText) {
            if (button && originalText) {
                button.disabled = false;
                button.innerHTML = originalText;
            }
        }

        // Get common request headers
        function getRequestHeaders() {
            return {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            };
        }

        // Handle successful add to cart
        function handleAddToCartSuccess(data) {
            showToast('success', data.message || 'Added to cart!');
            updateCartCount();
            document.dispatchEvent(new Event('cartUpdated'));
        }

        // Handle add to cart error
        function handleAddToCartError(data) {
            showToast('error', data.message || 'Failed to add to cart');
        }

        // Handle network error
        function handleNetworkError(error) {
            console.error('Error adding to cart:', error);
            showToast('error', 'Network error. Please try again.');
        }

        // Remove item from cart
        async function removeFromCart(cartId) {
            const result = await Swal.fire({
                title: 'Remove Item',
                text: 'Are you sure you want to remove this item from your cart?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            });

            if (result.isConfirmed) {
                try {
                    const response = await fetch(`/cart/${cartId}`, {
                        method: 'DELETE',
                        headers: getRequestHeaders()
                    });

                    const data = await response.json();

                    if (response.ok) {
                        handleRemoveItemSuccess(data);
                    } else {
                        handleRemoveItemError(data);
                    }
                } catch (error) {
                    handleNetworkError(error);
                }
            }
        }

        // Handle successful item removal
        function handleRemoveItemSuccess(data) {
            showToast('success', data.message || 'Item removed from cart');
            updateCartCount();
            document.dispatchEvent(new Event('cartUpdated'));

            if (window.location.pathname.includes('/cart')) {
                setTimeout(() => window.location.reload(), 1000);
            }
        }

        // Handle item removal error
        function handleRemoveItemError(data) {
            showToast('error', data.message || 'Failed to remove item');
        }

        // Clear entire cart
        async function clearCart() {
            const result = await Swal.fire({
                title: 'Clear Cart',
                text: 'Are you sure you want to remove all items from your cart?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, clear cart!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            });

            if (result.isConfirmed) {
                try {
                    const response = await fetch('/cart/clear', {
                        method: 'DELETE',
                        headers: getRequestHeaders()
                    });

                    const data = await response.json();

                    if (response.ok) {
                        handleClearCartSuccess(data);
                    } else {
                        handleClearCartError(data);
                    }
                } catch (error) {
                    handleNetworkError(error);
                }
            }
        }

        // Handle successful cart clear
        function handleClearCartSuccess(data) {
            showToast('success', data.message || 'Cart cleared successfully');
            updateCartCount();
            document.dispatchEvent(new Event('cartUpdated'));

            if (window.location.pathname.includes('/cart')) {
                setTimeout(() => window.location.reload(), 1000);
            }
        }

        // Handle cart clear error
        function handleClearCartError(data) {
            showToast('error', data.message || 'Failed to clear cart');
        }

        // Show toast notification
        function showToast(type, message) {
            const toastContainer = document.getElementById('toastContainer');
            const toast = createToastElement(type, message);

            toastContainer.appendChild(toast);
            initializeToast(toast);
        }

        // Create toast element
        function createToastElement(type, message) {
            const toast = document.createElement('div');
            toast.className = getToastClass(type);
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');

            toast.innerHTML = getToastHTML(type, message);

            return toast;
        }

        // Get toast CSS class based on type
        function getToastClass(type) {
            const typeClasses = {
                'success': 'bg-success',
                'error': 'bg-danger',
                'info': 'bg-info'
            };

            return `toast align-items-center text-white ${typeClasses[type] || 'bg-info'} border-0`;
        }

        // Get toast icon based on type
        function getToastIcon(type) {
            const icons = {
                'success': 'check-circle',
                'error': 'exclamation-circle',
                'info': 'info-circle'
            };

            return icons[type] || 'info-circle';
        }

        // Get toast HTML structure
        function getToastHTML(type, message) {
            const icon = getToastIcon(type);

            return `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-${icon} me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;
        }

        // Initialize Bootstrap toast
        function initializeToast(toastElement) {
            const bsToast = new bootstrap.Toast(toastElement, {
                autohide: true,
                delay: 3000
            });

            bsToast.show();

            toastElement.addEventListener('hidden.bs.toast', function() {
                toastElement.remove();
            });
        }

        // Check if user is guest and has cart items
        function checkGuestCart() {
            const cartSessionData = document.getElementById('cartSessionData');
            if (cartSessionData) {
                const guestToken = cartSessionData.dataset.guestToken;
                if (guestToken) {
                    console.log('Guest user with token:', guestToken);
                }
            }
        }

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
