<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - E-Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px;
        }
        
        .register-container {
            max-width: 450px;
            width: 100%;
            margin: 0 auto;
        }
        
        .register-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 40px;
            position: relative;
            overflow: hidden;
            border: none;
        }
        
        .register-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, #4361ee, #7209b7);
        }
        
        .register-header {
            text-align: center;
            margin-bottom: 35px;
        }
        
        .register-header h2 {
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
        }
        
        .brand-logo {
            color: #4361ee;
            font-weight: 700;
            font-size: 1.8rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            gap: 10px;
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
            border-color: #4361ee;
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
        
        .btn-register {
            background: linear-gradient(to right, #4361ee, #7209b7);
            border: none;
            padding: 14px;
            font-weight: 600;
            font-size: 1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            margin-top: 10px;
            letter-spacing: 0.5px;
            color: white;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
        }
        
        .register-footer {
            text-align: center;
            margin-top: 25px;
            color: #666;
            font-size: 0.9rem;
        }
        
        .register-footer a {
            color: #4361ee;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }
        
        .register-footer a:hover {
            color: #3a56d4;
            text-decoration: underline;
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
            
            .register-card {
                padding: 30px 25px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <div class="brand-logo">
                    <i class="fas fa-shopping-bag"></i>
                    <span>E-Shop</span>
                </div>
                <h2>Create Account</h2>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST">
                @csrf

                <!-- First & Last Name -->
                <div class="row mb-4">
                    <div class="col">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                    </div>
                    <small class="text-muted" style="font-size: 0.85rem;">We'll never share your email with anyone else.</small>
                </div>

                <!-- Phone (Optional) -->
                <div class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        <input type="text" name="phone" class="form-control" placeholder="Phone Number (Optional)">
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Create a strong password" required id="password">
                        <span class="input-group-text password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm your password" required id="confirmPassword">
                        <span class="input-group-text password-toggle" id="toggleConfirmPassword">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>

                <!-- Submit Button -->
                <button class="btn btn-register w-100" type="submit">Register</button>

                <div class="register-footer">
                    <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
                    <p class="mt-3 text-muted">
                    Want to explore our store?  
                    <a href="{{ route('home') }}" class="fw-semibold text-primary text-decoration-none">
                        Continue Shopping →
                    </a>
                </p>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password visibility toggle
            const togglePassword = document.getElementById('togglePassword');
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirmPassword');
            
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                const icon = this.querySelector('i');
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
            
            toggleConfirmPassword.addEventListener('click', function() {
                const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPasswordInput.setAttribute('type', type);
                
                const icon = this.querySelector('i');
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        });
    </script>
</body>
</html>