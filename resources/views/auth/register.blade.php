<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - iPower System</title>
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
        .register-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 480px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }
        .register-card .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .register-card .logo i {
            font-size: 50px;
            color: #00d2ff;
            background: rgba(0, 210, 255, 0.1);
            padding: 20px;
            border-radius: 50%;
        }
        .register-card .logo h3 {
            color: #fff;
            margin-top: 15px;
            font-weight: 600;
        }
        .register-card .logo span {
            color: #00d2ff;
        }
        .register-card .form-label {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
        }
        .register-card .form-control {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 12px 15px;
            border-radius: 10px;
        }
        .register-card .form-control:focus {
            background: rgba(255, 255, 255, 0.12);
            border-color: #00d2ff;
            box-shadow: 0 0 0 3px rgba(0, 210, 255, 0.2);
            color: #fff;
        }
        .register-card .form-control::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }
        .register-card .btn-register {
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
        .register-card .btn-register:hover {
            transform: translateY(-2px);
            color: #fff;
        }
        .register-card .login-link {
            color: rgba(255, 255, 255, 0.6);
            text-align: center;
            margin-top: 20px;
        }
        .register-card .login-link a {
            color: #00d2ff;
            text-decoration: none;
            font-weight: 500;
        }
        .register-card .login-link a:hover {
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

        /* Role Selection Cards */
        .role-options {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .role-option {
            flex: 1;
            min-width: 80px;
            text-align: center;
            padding: 12px 8px;
            border-radius: 10px;
            border: 2px solid rgba(255, 255, 255, 0.1);
            cursor: pointer;
            transition: all 0.3s;
            background: rgba(255, 255, 255, 0.05);
        }
        .role-option:hover {
            border-color: rgba(0, 210, 255, 0.3);
            background: rgba(0, 210, 255, 0.05);
        }
        .role-option input[type="radio"] {
            display: none;
        }
        .role-option input[type="radio"]:checked + .role-label {
            color: #00d2ff;
        }
        .role-option input[type="radio"]:checked ~ .role-card {
            border-color: #00d2ff;
            background: rgba(0, 210, 255, 0.1);
        }
        .role-option .role-label {
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            font-size: 13px;
        }
        .role-option .role-label i {
            font-size: 28px;
            display: block;
            margin-bottom: 5px;
        }
        .role-option .role-label .role-name {
            font-weight: 600;
        }
        .role-option .role-label .role-desc {
            font-size: 10px;
            opacity: 0.6;
        }
        .role-option.selected {
            border-color: #00d2ff;
            background: rgba(0, 210, 255, 0.1);
        }
        .role-option.selected .role-label {
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
    <div class="register-card">
        <div class="logo">
            <i class="fas fa-user-plus"></i>
            <h3>iPower <span>System</span></h3>
            <p style="color: rgba(255,255,255,0.5); font-size: 14px;">Create your account</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-3">
                <label class="form-label"><i class="fas fa-user"></i> Full Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                       placeholder="Enter your full name" value="{{ old('name') }}" required autocomplete="off">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label"><i class="fas fa-envelope"></i> Email Address</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                       placeholder="Enter your email" value="{{ old('email') }}" required autocomplete="off">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label class="form-label"><i class="fas fa-lock"></i> Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="registerPassword" 
                           class="form-control @error('password') is-invalid @enderror" 
                           placeholder="Enter password (min 8 chars)" required autocomplete="new-password">
                    <button type="button" class="toggle-password" onclick="togglePassword('registerPassword', this)">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label class="form-label"><i class="fas fa-check-circle"></i> Confirm Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password_confirmation" id="confirmPassword" 
                           class="form-control" placeholder="Confirm your password" required autocomplete="new-password">
                    <button type="button" class="toggle-password" onclick="togglePassword('confirmPassword', this)">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <!-- Role Selection -->
            <div class="mb-3">
                <label class="form-label"><i class="fas fa-user-tag"></i> Select Your Role</label>
                <div class="role-options">
                    <div class="role-option" onclick="selectRole('admin')">
                        <input type="radio" name="role" value="admin" id="role_admin">
                        <label for="role_admin" class="role-label">
                            <i class="fas fa-crown"></i>
                            <div class="role-name">Admin</div>
                            <div class="role-desc">Full Access</div>
                        </label>
                    </div>
                    <div class="role-option" onclick="selectRole('accountant')">
                        <input type="radio" name="role" value="accountant" id="role_accountant">
                        <label for="role_accountant" class="role-label">
                            <i class="fas fa-calculator"></i>
                            <div class="role-name">Accountant</div>
                            <div class="role-desc">Financial</div>
                        </label>
                    </div>
                    <div class="role-option" onclick="selectRole('sales_staff')">
                        <input type="radio" name="role" value="sales_staff" id="role_sales_staff" checked>
                        <label for="role_sales_staff" class="role-label">
                            <i class="fas fa-store"></i>
                            <div class="role-name">Sales Staff</div>
                            <div class="role-desc">Sales Only</div>
                        </label>
                    </div>
                </div>
                @error('role')
                    <div class="text-danger" style="font-size: 14px; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-register">
                <i class="fas fa-user-plus"></i> Register
            </button>
        </form>

        <div class="login-link">
            Already have an account? <a href="{{ route('login') }}">Login here</a>
        </div>

        <div class="back-home">
            <a href="{{ route('home') }}">
                <i class="fas fa-arrow-left"></i> Back to Home
            </a>
        </div>
    </div>

    <script>
        function selectRole(role) {
            document.querySelectorAll('.role-option').forEach(opt => {
                opt.classList.remove('selected');
            });
            document.querySelector(`.role-option input[value="${role}"]`).closest('.role-option').classList.add('selected');
            document.getElementById(`role_${role}`).checked = true;
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.role-option input[value="sales_staff"]').closest('.role-option').classList.add('selected');
            
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
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>