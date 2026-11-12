@extends('layouts.app')

@section('title', 'Edit Supplier - iPower System')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edit Supplier</h2>
    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Supplier Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name', $supplier->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email', $supplier->email) }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                           id="phone" name="phone" value="{{ old('phone', $supplier->phone) }}" placeholder="e.g., 011-2345678">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" 
                           id="address" name="address" value="{{ old('address', $supplier->address) }}" placeholder="e.g., 456 Business Park, Colombo">
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="payment_due" class="form-label">Payment Due (Rs.)</label>
                    <input type="number" step="0.01" class="form-control @error('payment_due') is-invalid @enderror" 
                           id="payment_due" name="payment_due" value="{{ old('payment_due', $supplier->payment_due) }}" min="0">
                    @error('payment_due')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Supplier
            </button>
            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection