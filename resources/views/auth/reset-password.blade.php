<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - iPower System</title>
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
        .reset-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }
        .reset-card .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .reset-card .logo i {
            font-size: 50px;
            color: #00d2ff;
            background: rgba(0, 210, 255, 0.1);
            padding: 20px;
            border-radius: 50%;
        }
        .reset-card .logo h3 {
            color: #fff;
            margin-top: 15px;
            font-weight: 600;
        }
        .reset-card .logo span {
            color: #00d2ff;
        }
        .reset-card .form-label {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
        }
        .reset-card .form-control {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 12px 15px;
            border-radius: 10px;
        }
        .reset-card .form-control:focus {
            background: rgba(255, 255, 255, 0.12);
            border-color: #00d2ff;
            box-shadow: 0 0 0 3px rgba(0, 210, 255, 0.2);
            color: #fff;
        }
        .reset-card .form-control::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }
        .reset-card .form-control[readonly] {
            opacity: 0.6;
            cursor: not-allowed;
        }
        .reset-card .btn-reset {
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
        .reset-card .btn-reset:hover {
            transform: translateY(-2px);
            color: #fff;
        }
        .reset-card .login-link {
            color: rgba(255, 255, 255, 0.6);
            text-align: center;
            margin-top: 20px;
        }
        .reset-card .login-link a {
            color: #00d2ff;
            text-decoration: none;
            font-weight: 500;
        }
        .reset-card .login-link a:hover {
            text-decoration: underline;
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
        .subtitle {
            color: rgba(255, 255, 255, 0.5);
            text-align: center;
            font-size: 14px;
            margin-bottom: 25px;
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
    </style>
</head>
<body>
    <div class="reset-card">
        <div class="logo">
            <i class="fas fa-lock-open"></i>
            <h3>iPower <span>System</span></h3>
            <p style="color: rgba(255,255,255,0.5); font-size: 14px;">Set New Password</p>
        </div>

        <p class="subtitle">Enter your new password below.</p>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="mb-3">
                <label class="form-label"><i class="fas fa-envelope"></i> Email Address</label>
                <input type="email" name="email" class="form-control" 
                       value="{{ $email }}" required readonly>
            </div>

            <div class="mb-3">
                <label class="form-label"><i class="fas fa-lock"></i> New Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="resetPassword" 
                           class="form-control" placeholder="Enter new password" required>
                    <button type="button" class="toggle-password" onclick="togglePassword('resetPassword', this)">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label"><i class="fas fa-check-circle"></i> Confirm Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password_confirmation" id="confirmResetPassword" 
                           class="form-control" placeholder="Confirm new password" required>
                    <button type="button" class="toggle-password" onclick="togglePassword('confirmResetPassword', this)">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-reset">
                <i class="fas fa-save"></i> Reset Password
            </button>
        </form>

        <div class="login-link">
            Remember your password? <a href="{{ route('login') }}">Login here</a>
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