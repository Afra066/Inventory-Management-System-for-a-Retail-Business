@extends('layouts.app')

@section('title', 'Add Expense - iPower System')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-money-bill-wave-alt" style="color: #00d2ff;"></i> Add New Expense</h2>
    <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('expenses.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="description" class="form-label">
                        <i class="fas fa-align-left" style="color: #00d2ff;"></i> Description <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control @error('description') is-invalid @enderror" 
                           id="description" name="description" value="{{ old('description') }}" 
                           placeholder="Enter expense description" required>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="amount" class="form-label">
                        <i class="fas fa-money-bill-wave" style="color: #00d2ff;"></i> Amount (Rs.) <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text" style="background: #1a1a2e; color: #fff; border-color: #1a1a2e;">
                            <i class="fas fa-rupee-sign"></i>
                        </span>
                        <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" 
                               id="amount" name="amount" value="{{ old('amount') }}" 
                               placeholder="0.00" min="0" required>
                    </div>
                    @error('amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="category" class="form-label">
                        <i class="fas fa-tag" style="color: #00d2ff;"></i> Category
                    </label>
                    <select class="form-control @error('category') is-invalid @enderror" id="category" name="category">
                        <option value="">Select Category</option>
                        <option value="Utilities" {{ old('category') == 'Utilities' ? 'selected' : '' }}>Utilities</option>
                        <option value="Rent" {{ old('category') == 'Rent' ? 'selected' : '' }}>Rent</option>
                        <option value="Salaries" {{ old('category') == 'Salaries' ? 'selected' : '' }}>Salaries</option>
                        <option value="Transport" {{ old('category') == 'Transport' ? 'selected' : '' }}>Transport</option>
                        <option value="Office Supplies" {{ old('category') == 'Office Supplies' ? 'selected' : '' }}>Office Supplies</option>
                        <option value="Maintenance" {{ old('category') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="Marketing" {{ old('category') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                        <option value="Food & Beverage" {{ old('category') == 'Food & Beverage' ? 'selected' : '' }}>Food & Beverage</option>
                        <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="expense_date" class="form-label">
                        <i class="fas fa-calendar-day" style="color: #00d2ff;"></i> Expense Date
                    </label>
                    <input type="date" class="form-control @error('expense_date') is-invalid @enderror" 
                           id="expense_date" name="expense_date" value="{{ old('expense_date', date('Y-m-d')) }}">
                    @error('expense_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="notes" class="form-label">
                        <i class="fas fa-pen" style="color: #00d2ff;"></i> Notes
                    </label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                              id="notes" name="notes" rows="3" placeholder="Add any additional notes">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Expense
            </button>
            <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<style>
    .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .form-control {
        border-radius: 8px;
    }
    .form-control:focus {
        border-color: #00d2ff;
        box-shadow: 0 0 0 0.2rem rgba(0, 210, 255, 0.25);
    }
    .input-group-text {
        border-radius: 8px 0 0 8px;
    }
    .form-control {
        border-radius: 0 8px 8px 0;
    }
    .btn {
        border-radius: 8px;
    }
</style>
@endsection