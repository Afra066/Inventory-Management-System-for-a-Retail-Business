@extends('layouts.app')

@section('title', 'Edit Expense - iPower System')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edit Expense</h2>
    <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('description') is-invalid @enderror" 
                           id="description" name="description" value="{{ old('description', $expense->description) }}" required>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="amount" class="form-label">Amount (Rs.) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" 
                           id="amount" name="amount" value="{{ old('amount', $expense->amount) }}" min="0" required>
                    @error('amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-control @error('category') is-invalid @enderror" id="category" name="category">
                        <option value="">Select Category</option>
                        <option value="Utilities" {{ old('category', $expense->category) == 'Utilities' ? 'selected' : '' }}>Utilities</option>
                        <option value="Rent" {{ old('category', $expense->category) == 'Rent' ? 'selected' : '' }}>Rent</option>
                        <option value="Salaries" {{ old('category', $expense->category) == 'Salaries' ? 'selected' : '' }}>Salaries</option>
                        <option value="Transport" {{ old('category', $expense->category) == 'Transport' ? 'selected' : '' }}>Transport</option>
                        <option value="Office Supplies" {{ old('category', $expense->category) == 'Office Supplies' ? 'selected' : '' }}>Office Supplies</option>
                        <option value="Maintenance" {{ old('category', $expense->category) == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="Marketing" {{ old('category', $expense->category) == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                        <option value="Other" {{ old('category', $expense->category) == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="expense_date" class="form-label">Expense Date</label>
                    <input type="date" class="form-control @error('expense_date') is-invalid @enderror" 
                           id="expense_date" name="expense_date" value="{{ old('expense_date', $expense->expense_date ? date('Y-m-d', strtotime($expense->expense_date)) : date('Y-m-d')) }}">
                    @error('expense_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                              id="notes" name="notes" rows="3">{{ old('notes', $expense->notes) }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Expense
            </button>
            <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection