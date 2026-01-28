<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/favicon.png') }}">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons (For icons to work) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS (Keep your existing styles) -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
        }

        .sidebar .nav-link {
            color: #fff;
        }

        .sidebar .nav-link:hover {
            background-color: #495057;
        }

        .sidebar .nav-link.active {
            background-color: #007bff;
        }

        .content {
            padding: 20px;
        }
    </style>
    @yield('styles')
</head>

<body>

    @if (auth()->check() && auth()->user()->role === 'admin')
        @include('admin.partials.navbar')
        <div class="container-fluid">
            <div class="row">
                @include('admin.partials.sidebar')
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 content">
                    

                    <div class="alert-container position-fixed top-0 start-50 translate-middle-x mt-3"
                        style="z-index: 9999;">
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
            </div>
        </div>
    @else
        <script>
            // Redirect non-admin users to home page
            window.location.href = "{{ url('login') }}";
        </script>
        @yield('content')
    @endif

    @include('admin.partials.footer')

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('scripts')
</body>

</html>
