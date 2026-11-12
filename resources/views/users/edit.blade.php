@extends('layouts.app')

@section('title', 'Edit Employee - iPower System')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edit Employee</h2>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                    <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                        <!-- Admin role removed from edit as well -->
                        <option value="accountant" {{ old('role', $user->role) == 'accountant' ? 'selected' : '' }}>Accountant</option>
                        <option value="sales_staff" {{ old('role', $user->role) == 'sales_staff' ? 'selected' : '' }}>Sales Staff</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        <strong>Note:</strong> Leave password empty if you don't want to change it.
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <div class="password-wrapper">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Leave empty to keep current">
                        <button type="button" class="toggle-password" onclick="togglePassword('password', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="password-wrapper">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Leave empty to keep current">
                        <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Employee
            </button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<style>
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
        color: rgba(0, 0, 0, 0.5);
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
</style>

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
</script>
@endsection