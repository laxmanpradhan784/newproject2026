<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Shop</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #7fa6cc 0%, #6b8db3 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin: 0;
            position: relative;
        }

        /* Create a blurred background effect */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: inherit;
            z-index: -1;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
        }

        .login-card {
            background: rgb(105 128 145 / 0%);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.2);
            padding: 32px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            position: relative;
            transition: all 0.3s ease;
        }

        .login-card:hover {
            background: rgba(123, 165, 212, 0.95);
            box-shadow: 0 8px 40px rgba(31, 38, 135, 0.25);
        }

        .top-logo {
            position: absolute;
            top: 20px;
            left: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            z-index: 1;
        }

        .logo-icon {
            font-size: 22px;
            color: #3b82f6;
            background: rgba(255, 255, 255, 0.9);
            padding: 6px;
            border-radius: 8px;
        }

        .logo-text {
            font-size: 20px;
            font-weight: 600;
            color: #1e293b;
            background: rgba(255, 255, 255, 0.9);
            padding: 2px 8px;
            border-radius: 6px;
        }

        .form-header {
            text-align: center;
            margin-bottom: 32px;
            /* padding-top: 40px; */
        }

        .form-title {
            font-size: 24px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .form-subtitle {
            color: #64748b;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: #475569;
            font-size: 14px;
        }

        .input-with-icon {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            z-index: 1;
        }

        .form-control {
            width: 100%;
            padding: 12px 12px 12px 42px;
            border: 1px solid rgba(203, 213, 225, 0.8);
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
        }

        .form-control:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
            background: white;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(203, 213, 225, 0.8);
            border-radius: 6px;
            color: #64748b;
            cursor: pointer;
            padding: 6px 10px;
            font-size: 14px;
            transition: all 0.2s;
        }

        .password-toggle:hover {
            background: white;
            border-color: #94a3b8;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 8px;
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login:disabled {
            background: #93c5fd;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 28px 0;
            color: #94a3b8;
        }

        .divider-line {
            flex: 1;
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(203, 213, 225, 0.6), transparent);
        }

        .divider-text {
            padding: 0 15px;
            font-size: 14px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 5px 15px;
        }

        .btn-google {
            width: 100%;
            padding: 14px;
            background: #db4437;
            border: 1px solid #db4437;
            border-radius: 10px;
            color: white;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
        }

        .btn-google:hover {
            background: #c33d32;
            border-color: #c33d32;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(219, 68, 55, 0.3);
            color: white;
            text-decoration: none;
        }

        .btn-google:active {
            transform: translateY(0);
        }

        .links {
            margin-top: 28px;
            text-align: center;
        }

        .link-text {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 15px;
            background: rgba(255, 255, 255, 0.7);
            padding: 5px 10px;
            border-radius: 6px;
            display: inline-block;
        }

        .link-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .link-btn {
            padding: 10px 18px;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(203, 213, 225, 0.8);
            border-radius: 8px;
            color: #475569;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .link-btn:hover {
            background: white;
            border-color: #94a3b8;
            transform: translateY(-2px);
            text-decoration: none;
        }

        .alert {
            padding: 14px 18px;
            background: rgba(254, 226, 226, 0.95);
            border: 1px solid rgba(254, 202, 202, 0.8);
            border-radius: 10px;
            color: #dc2626;
            margin-bottom: 24px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            backdrop-filter: blur(5px);
            animation: slideDown 0.3s ease;
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

        .alert i {
            font-size: 16px;
        }

        .alert .btn-close {
            margin-left: auto;
            padding: 0;
            background: none;
            border: none;
            color: #dc2626;
            cursor: pointer;
            font-size: 18px;
            opacity: 0.8;
            transition: opacity 0.2s;
        }

        .alert .btn-close:hover {
            opacity: 1;
        }

        @media (max-width: 480px) {
            body {
                padding: 15px;
                background: linear-gradient(135deg, #7fa6cc 0%, #6b8db3 100%);
            }

            .login-card {
                padding: 28px 20px;
                background: rgba(59, 59, 59, 0.95);
                backdrop-filter: blur(20px);
            }

            .top-logo {
                top: 15px;
                left: 15px;
            }

            .logo-text {
                font-size: 18px;
            }

            .link-buttons {
                flex-direction: column;
                gap: 10px;
            }
        }

        @media (max-width: 360px) {
            .login-card {
                padding: 24px 16px;
            }

            .top-logo {
                top: 12px;
                left: 12px;
            }

            .logo-text {
                font-size: 16px;
                padding: 2px 6px;
            }

            .logo-icon {
                padding: 5px;
                font-size: 20px;
            }
        }

        /* Subtle floating animation for the card */
        @keyframes floatIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-card {
            animation: floatIn 0.5s ease-out;
        }
    </style>
</head>

<body>

    <!-- Logo in top-left corner -->
    <a href="{{ route('home') }}" class="top-logo">
        <i class="fas fa-shopping-bag logo-icon"></i>
        <span class="logo-text">E-Shop</span>
    </a>

    <div class="login-container">
        <div class="login-card">
            <div class="form-header">
                <div class="form-title">Welcome Back</div>
                <div class="form-subtitle">Sign in to your account</div>
            </div>

            @if ($errors->any())
                <div class="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $errors->first() }}</span>
                    <button type="button" class="btn-close" onclick="this.parentElement.style.display='none'">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" id="loginForm">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email" class="form-control"
                            placeholder="Enter your email" required value="{{ old('email') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" class="form-control"
                            placeholder="Enter your password" required>
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button class="btn-login" type="submit" id="loginButton">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </button>
            </form>

            <div class="divider">
                <div class="divider-line"></div>
                <div class="divider-text">or</div>
                <div class="divider-line"></div>
            </div>

            <a href="{{ url('/auth/google') }}" class="btn-google">
                <i class="fab fa-google"></i>
                Continue with Google
            </a>

            <div class="links">
                <div class="link-text">Don't have an account?</div>
                <div class="link-buttons">
                    <a href="{{ route('register') }}" class="link-btn">
                        <i class="fas fa-user-plus"></i> Sign Up
                    </a>
                    <a href="{{ route('home') }}" class="link-btn">
                        <i class="fas fa-store"></i> Browse Store
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password visibility toggle
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.type === 'password' ? 'text' : 'password';
                    passwordInput.type = type;

                    const icon = this.querySelector('i');
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');

                    // Add feedback animation
                    this.style.transform = 'translateY(-50%) scale(1.1)';
                    setTimeout(() => {
                        this.style.transform = 'translateY(-50%) scale(1)';
                    }, 150);
                });
            }

            // Form submission
            const loginForm = document.getElementById('loginForm');
            const loginButton = document.getElementById('loginButton');

            if (loginForm && loginButton) {
                loginForm.addEventListener('submit', function() {
                    loginButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Signing In...';
                    loginButton.disabled = true;

                    // Add ripple effect
                    const ripple = document.createElement('span');
                    const rect = loginButton.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = event.clientX - rect.left - size / 2;
                    const y = event.clientY - rect.top - size / 2;

                    ripple.style.cssText = `
                        position: absolute;
                        border-radius: 50%;
                        background: rgba(255, 255, 255, 0.7);
                        transform: scale(0);
                        animation: ripple 0.6s linear;
                        width: ${size}px;
                        height: ${size}px;
                        top: ${y}px;
                        left: ${x}px;
                    `;

                    loginButton.appendChild(ripple);
                    setTimeout(() => ripple.remove(), 600);
                });
            }

            // Auto-focus email field
            const emailField = document.getElementById('email');
            if (emailField) {
                setTimeout(() => {
                    emailField.focus();
                    emailField.style.transform = 'scale(1.02)';
                    setTimeout(() => {
                        emailField.style.transform = 'scale(1)';
                    }, 200);
                }, 300);
            }

            // Add ripple animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        });
    </script>
</body>

</html>
