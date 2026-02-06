<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - E-Shop</title>
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

        .register-container {
            width: 100%;
            max-width: 450px;
        }

        .register-card {
            background: rgb(105 128 145 / 0%);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.2);
            padding: 32px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            position: relative;
            transition: all 0.3s ease;
        }

        .register-card:hover {
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

        .btn-register {
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

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.3);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        .btn-register:disabled {
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

        .name-row {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .name-group {
            flex: 1;
        }

        .terms-checkbox {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin: 25px 0;
            padding: 15px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            border: 1px solid rgba(203, 213, 225, 0.8);
        }

        .terms-checkbox input[type="checkbox"] {
            margin-top: 2px;
            accent-color: #3b82f6;
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .terms-text {
            font-size: 13px;
            color: #475569;
            line-height: 1.4;
        }

        .terms-text a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
        }

        .terms-text a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            body {
                padding: 15px;
                background: linear-gradient(135deg, #7fa6cc 0%, #6b8db3 100%);
            }

            .register-card {
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

            .name-row {
                flex-direction: column;
                gap: 20px;
            }

            .link-buttons {
                flex-direction: column;
                gap: 10px;
            }
        }

        @media (max-width: 360px) {
            .register-card {
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

        .register-card {
            animation: floatIn 0.5s ease-out;
        }

        /* Password strength indicator */
        .password-strength {
            height: 4px;
            background: #e2e8f0;
            border-radius: 2px;
            margin-top: 8px;
            overflow: hidden;
            position: relative;
        }

        .strength-meter {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-weak { background: #ef4444; width: 25%; }
        .strength-fair { background: #f59e0b; width: 50%; }
        .strength-good { background: #3b82f6; width: 75%; }
        .strength-strong { background: #10b981; width: 100%; }

        .strength-text {
            font-size: 12px;
            color: #64748b;
            margin-top: 4px;
            text-align: right;
        }
    </style>
</head>

<body>

    <!-- Logo in top-left corner -->
    <a href="{{ route('home') }}" class="top-logo">
        <i class="fas fa-shopping-bag logo-icon"></i>
        <span class="logo-text">E-Shop</span>
    </a>

    <div class="register-container">
        <div class="register-card">
            <div class="form-header">
                <div class="form-title">Create Account</div>
                <div class="form-subtitle">Join our community today</div>
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

            <form action="{{ route('register.post') }}" method="POST" id="registerForm">
                @csrf

                <div class="name-row">
                    <div class="name-group">
                        <label for="first_name" class="form-label">First Name</label>
                        <div class="input-with-icon">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" id="first_name" name="first_name" class="form-control"
                                placeholder="Enter your name" required value="{{ old('first_name') }}">
                        </div>
                    </div>
                    <div class="name-group">
                        <label for="last_name" class="form-label">Last Name</label>
                        <div class="input-with-icon">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" id="last_name" name="last_name" class="form-control"
                                placeholder="Enter your name" required value="{{ old('last_name') }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email" class="form-control"
                            placeholder="Enter your email" required value="{{ old('email') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">Phone Number (Optional)</label>
                    <div class="input-with-icon">
                        <i class="fas fa-phone input-icon"></i>
                        <input type="tel" id="phone" name="phone" class="form-control"
                            placeholder="Enter your phone number" value="{{ old('phone') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" class="form-control"
                            placeholder="Create a strong password" required>
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="confirmPassword" name="password_confirmation" class="form-control"
                            placeholder="Confirm your password" required>
                        <button type="button" class="password-toggle" id="toggleConfirmPassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="strength-text" id="passwordMatch"></div>
                </div>

                <button class="btn-register" type="submit" id="registerButton">
                    <i class="fas fa-user-plus"></i> Create Account
                </button>
            </form>

            <div class="links">
                <div class="link-buttons">
                    <a href="{{ route('login') }}" class="link-btn">
                        <i class="fas fa-sign-in-alt"></i> Sign In
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
            // Password visibility toggles
            const togglePassword = document.getElementById('togglePassword');
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirmPassword');

            function setupPasswordToggle(toggleBtn, inputField) {
                toggleBtn.addEventListener('click', function() {
                    const type = inputField.type === 'password' ? 'text' : 'password';
                    inputField.type = type;

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

            if (togglePassword && passwordInput) {
                setupPasswordToggle(togglePassword, passwordInput);
            }

            if (toggleConfirmPassword && confirmPasswordInput) {
                setupPasswordToggle(toggleConfirmPassword, confirmPasswordInput);
            }

            // Password strength checker
            function checkPasswordStrength(password) {
                let strength = 0;
                const meter = document.getElementById('strengthMeter');
                const text = document.getElementById('strengthText');

                if (!password) {
                    meter.className = 'strength-meter';
                    meter.style.width = '0%';
                    text.textContent = 'Password strength';
                    return;
                }

                // Check password length
                if (password.length >= 8) strength++;
                if (password.length >= 12) strength++;

                // Check for different character types
                if (/[a-z]/.test(password)) strength++; // lowercase
                if (/[A-Z]/.test(password)) strength++; // uppercase
                if (/[0-9]/.test(password)) strength++; // numbers
                if (/[^A-Za-z0-9]/.test(password)) strength++; // special characters

                // Update strength meter
                meter.className = 'strength-meter';
                if (strength < 2) {
                    meter.classList.add('strength-weak');
                    text.textContent = 'Weak password';
                    text.style.color = '#ef4444';
                } else if (strength < 4) {
                    meter.classList.add('strength-fair');
                    text.textContent = 'Fair password';
                    text.style.color = '#f59e0b';
                } else if (strength < 6) {
                    meter.classList.add('strength-good');
                    text.textContent = 'Good password';
                    text.style.color = '#3b82f6';
                } else {
                    meter.classList.add('strength-strong');
                    text.textContent = 'Strong password!';
                    text.style.color = '#10b981';
                }
            }

            // Password match checker
            function checkPasswordMatch() {
                const matchText = document.getElementById('passwordMatch');
                if (!confirmPasswordInput.value) {
                    matchText.textContent = '';
                    return;
                }

                if (passwordInput.value === confirmPasswordInput.value) {
                    matchText.textContent = 'Passwords match ✓';
                    matchText.style.color = '#10b981';
                    confirmPasswordInput.style.borderColor = '#10b981';
                } else {
                    matchText.textContent = 'Passwords do not match ✗';
                    matchText.style.color = '#ef4444';
                    confirmPasswordInput.style.borderColor = '#ef4444';
                }
            }

            passwordInput.addEventListener('input', function() {
                checkPasswordStrength(this.value);
                checkPasswordMatch();
            });

            confirmPasswordInput.addEventListener('input', checkPasswordMatch);

            // Form submission
            const registerForm = document.getElementById('registerForm');
            const registerButton = document.getElementById('registerButton');

            if (registerForm && registerButton) {
                registerForm.addEventListener('submit', function(event) {
                    // Check password match before submitting
                    if (passwordInput.value !== confirmPasswordInput.value) {
                        event.preventDefault();
                        confirmPasswordInput.focus();
                        confirmPasswordInput.style.borderColor = '#ef4444';
                        confirmPasswordInput.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.15)';
                        return;
                    }

                    registerButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Account...';
                    registerButton.disabled = true;
                });
            }

            // Auto-focus first name field
            const firstNameField = document.getElementById('first_name');
            if (firstNameField) {
                setTimeout(() => {
                    firstNameField.focus();
                    firstNameField.style.transform = 'scale(1.02)';
                    setTimeout(() => {
                        firstNameField.style.transform = 'scale(1)';
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