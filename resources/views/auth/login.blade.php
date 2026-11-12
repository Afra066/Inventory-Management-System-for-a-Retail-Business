<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - iPower System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a2e, #16213e, #0f3460);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }
        .login-card .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-card .logo i {
            font-size: 50px;
            color: #00d2ff;
            background: rgba(0, 210, 255, 0.1);
            padding: 20px;
            border-radius: 50%;
        }
        .login-card .logo h3 {
            color: #fff;
            margin-top: 15px;
            font-weight: 600;
        }
        .login-card .logo span {
            color: #00d2ff;
        }
        .login-card .logo p {
            color: rgba(255, 255, 255, 0.5);
            font-size: 14px;
        }
        .login-card .form-label {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
        }
        .login-card .form-control {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 12px 15px;
            border-radius: 10px;
        }
        .login-card .form-control:focus {
            background: rgba(255, 255, 255, 0.12);
            border-color: #00d2ff;
            box-shadow: 0 0 0 3px rgba(0, 210, 255, 0.2);
            color: #fff;
        }
        .login-card .form-control::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }
        .login-card .btn-login {
            background: linear-gradient(135deg, #00d2ff, #3a7bd5);
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            width: 100%;
            color: #fff;
            transition: transform 0.2s;
        }
        .login-card .btn-login:hover {
            transform: translateY(-2px);
            color: #fff;
        }
        .alert-danger {
            background: rgba(255, 0, 0, 0.2);
            border: 1px solid rgba(255, 0, 0, 0.3);
            color: #ff6b6b;
            border-radius: 10px;
            padding: 10px 15px;
        }
        .alert-success {
            background: rgba(0, 255, 0, 0.1);
            border: 1px solid rgba(0, 255, 0, 0.2);
            color: #51cf66;
            border-radius: 10px;
            padding: 10px 15px;
        }
        .forgot-password {
            text-align: right;
            margin-top: 5px;
        }
        .forgot-password a {
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            font-size: 13px;
            transition: 0.3s;
        }
        .forgot-password a:hover {
            color: #00d2ff;
        }
        .back-home {
            text-align: center;
            margin-top: 15px;
        }
        .back-home a {
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            font-size: 13px;
            transition: 0.3s;
        }
        .back-home a:hover {
            color: #00d2ff;
        }

        /* Password Toggle */
        .password-wrapper {
            position: relative;
        }
        .password-wrapper input {
            padding-right: 45px;
        }
        .password-wrapper .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: rgba(255, 255, 255, 0.5);
            transition: 0.3s;
            background: none;
            border: none;
            font-size: 16px;
            padding: 0;
            z-index: 10;
        }
        .password-wrapper .toggle-password:hover {
            color: #00d2ff;
        }

        .alert {
            animation: slideDown 0.5s ease;
        }
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Hide autofill suggestions */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px rgba(26, 26, 46, 0.9) inset !important;
            -webkit-text-fill-color: #fff !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        /* Disable autofill background */
        input[type="email"]:-webkit-autofill,
        input[type="password"]:-webkit-autofill {
            background-color: transparent !important;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">
            <i class="fas fa-mobile-alt"></i>
            <h3>iPower <span>System</span></h3>
            <p>Inventory Management System</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Error Message -->
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" autocomplete="off">
            @csrf
            <div class="mb-3">
                <label class="form-label"><i class="fas fa-envelope"></i> Email Address</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                       placeholder="Enter your email" value="{{ old('email') }}" required autofocus 
                       autocomplete="off" readonly onfocus="this.removeAttribute('readonly')">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label"><i class="fas fa-lock"></i> Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="loginPassword" 
                           class="form-control @error('password') is-invalid @enderror" 
                           placeholder="Enter your password" required 
                           autocomplete="new-password" readonly onfocus="this.removeAttribute('readonly')">
                    <button type="button" class="toggle-password" onclick="togglePassword('loginPassword', this)">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="forgot-password">
                <a href="{{ route('password.request') }}">Forgot Password?</a>
            </div>
            <button type="submit" class="btn-login mt-3">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>

        <div style="margin-top: 20px; text-align: center; color: rgba(255,255,255,0.3); font-size: 12px;">
            <p>Employee Login Only</p>
            <p style="font-size: 11px; color: rgba(255,255,255,0.4);">
                Contact your administrator for credentials
            </p>
        </div>

        <div class="back-home">
            <a href="{{ route('home') }}">
                <i class="fas fa-arrow-left"></i> Back to Home
            </a>
        </div>
    </div>

    <script>
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const closeBtn = alert.querySelector('.btn-close');
                    if (closeBtn) {
                        closeBtn.click();
                    }
                });
            }, 5000);
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>