@extends('layouts.app')

@section('title', 'Edit Invoice Status - iPower System')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Update Invoice Status</h2>
    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> 
            <strong>Invoice #{{ $invoice->invoice_number }}</strong> 
            for <strong>{{ $invoice->customer->name ?? 'N/A' }}</strong>
            <br>Current Status: 
            <span class="badge bg-{{ $invoice->payment_status == 'paid' ? 'success' : ($invoice->payment_status == 'pending' ? 'warning' : 'info') }}">
                {{ ucfirst($invoice->payment_status) }}
            </span>
        </div>

        <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="payment_status" class="form-label">Payment Status <span class="text-danger">*</span></label>
                    <select class="form-control @error('payment_status') is-invalid @enderror" 
                            id="payment_status" name="payment_status" required>
                        <option value="pending" {{ old('payment_status', $invoice->payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ old('payment_status', $invoice->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="partial" {{ old('payment_status', $invoice->payment_status) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    @error('payment_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Status
            </button>
            <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection