<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-dark: #3a56d4;
            --secondary-color: #7209b7;
            --light-bg: #f8f9fa;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --input-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
        }
        
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px;
        }
        
        .login-container {
            max-width: 420px;
            width: 100%;
            margin: 0 auto;
        }
        
        .login-card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            padding: 40px;
            position: relative;
            overflow: hidden;
            border: none;
        }
        
        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 35px;
        }
        
        .login-header h2 {
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
        }
        
        .login-header p {
            color: #666;
            font-size: 0.95rem;
        }
        
        .brand-logo {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.8rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            gap: 10px;
        }
        
        .brand-logo i {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .form-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
        
        .form-control {
            padding: 14px 16px;
            border: 2px solid #e1e5eb;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #fafbfc;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
            background-color: white;
        }
        
        .input-group-text {
            background-color: #f8f9fa;
            border: 2px solid #e1e5eb;
            border-right: none;
            color: #6c757d;
        }
        
        .password-toggle {
            cursor: pointer;
            background-color: #f8f9fa;
            border: 2px solid #e1e5eb;
            border-left: none;
        }
        
        .btn-login {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 14px;
            font-weight: 600;
            font-size: 1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            margin-top: 10px;
            letter-spacing: 0.5px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .login-footer {
            text-align: center;
            margin-top: 25px;
            color: #666;
            font-size: 0.9rem;
        }
        
        .login-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }
        
        .login-footer a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
            color: #999;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e1e5eb;
        }
        
        .divider span {
            padding: 0 15px;
            font-size: 0.85rem;
        }
        
        .social-login {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }
        
        .social-btn {
            flex: 1;
            padding: 12px;
            border-radius: 10px;
            border: 2px solid #e1e5eb;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-weight: 600;
            color: #555;
            transition: all 0.3s ease;
        }
        
        .social-btn:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }
        
        .social-btn.google {
            color: #DB4437;
        }
        
        .social-btn.facebook {
            color: #4267B2;
        }
        
        .alert {
            border-radius: 10px;
            padding: 14px 18px;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .alert-danger {
            background-color: #fee;
            color: #c33;
            border-left: 4px solid #c33;
        }
        
        @media (max-width: 576px) {
            body {
                padding: 15px;
            }
            
            .login-card {
                padding: 30px 25px;
            }
            
            .social-login {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="brand-logo">
                    <i class="fas fa-shopping-bag"></i>
                    <span>E-Shop</span>
                </div>
                <h2>Welcome Back</h2>
                <p>Sign in to your account to continue shopping</p>
            </div>
            
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" id="loginForm">
                @csrf
                
                <div class="mb-4">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" id="email" name="email" class="form-control" 
                               placeholder="you@example.com" required value="{{ old('email') }}">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" id="password" name="password" class="form-control" 
                               placeholder="Enter your password" required>
                        <span class="input-group-text password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    {{-- <div class="mt-2 text-end">
                        <a href="{{ route('password.request') }}" class="text-decoration-none" style="font-size: 0.85rem;">
                            Forgot password?
                        </a>
                    </div> --}}
                </div>

                <button class="btn btn-primary w-100 btn-login" type="submit" id="loginButton">
                    <i class="fas fa-sign-in-alt me-2"></i> Sign In
                </button>
            </form>
            
            <div class="divider">
                <span>Or continue with</span>
            </div>
            
            <div class="social-login">
                <button type="button" class="social-btn google">
                    <i class="fab fa-google"></i> Google
                </button>
                <button type="button" class="social-btn facebook">
                    <i class="fab fa-facebook-f"></i> Facebook
                </button>
            </div>
            
            <div class="login-footer">
                <p>Don't have an account? <a href="{{ route('register') }}">Create an account</a></p>
                <p class="mt-3 text-muted">
                    Want to explore our store?  
                    <a href="{{ route('home') }}" class="fw-semibold text-primary text-decoration-none">
                        Continue Shopping →
                    </a>
                </p>

                <p class="mt-2" style="font-size: 0.8rem; color: #888;">
                    By signing in, you agree to our <a href="#">Terms</a> and <a href="#">Privacy Policy</a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password visibility toggle
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Toggle icon
                const icon = this.querySelector('i');
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
            
            // Form submission animation
            const loginForm = document.getElementById('loginForm');
            const loginButton = document.getElementById('loginButton');
            
            loginForm.addEventListener('submit', function() {
                loginButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Signing In...';
                loginButton.disabled = true;
            });
            
            // Input focus effects
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.parentElement.classList.remove('focused');
                });
            });
            
            // Social login buttons animation
            const socialBtns = document.querySelectorAll('.social-btn');
            socialBtns.forEach(btn => {
                btn.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px)';
                });
                
                btn.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>
</html>