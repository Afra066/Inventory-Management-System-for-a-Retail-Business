@extends('layouts.app')

@section('title', 'Add Product - iPower System')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-box" style="color: #00d2ff;"></i> Add New Product</h2>
    <div>
        @if(request()->has('supplier_id'))
            <a href="{{ route('suppliers.show', request()->supplier_id) }}" class="btn btn-info me-2">
                <i class="fas fa-arrow-left"></i> Back to Supplier
            </a>
        @endif
        <a href="{{ route('products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Products
        </a>
    </div>
</div>

@if(request()->has('supplier_id'))
    @php
        $supplier = \App\Models\Supplier::find(request()->supplier_id);
    @endphp
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i class="fas fa-info-circle"></i> 
        Adding product for supplier: <strong>{{ $supplier->name ?? 'N/A' }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('products.store') }}" method="POST" autocomplete="off">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">
                        <i class="fas fa-tag" style="color: #00d2ff;"></i> Product Name <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" 
                           placeholder="Enter product name" required
                           autocomplete="off" readonly onfocus="this.removeAttribute('readonly')">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="category" class="form-label">
                        <i class="fas fa-folder" style="color: #00d2ff;"></i> Category
                    </label>
                    <input type="text" class="form-control @error('category') is-invalid @enderror" 
                           id="category" name="category" value="{{ old('category') }}" 
                           placeholder="Enter category"
                           autocomplete="off" readonly onfocus="this.removeAttribute('readonly')">
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="quantity" class="form-label">
                        <i class="fas fa-cubes" style="color: #00d2ff;"></i> Quantity <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                           id="quantity" name="quantity" value="{{ old('quantity', 0) }}" 
                           placeholder="0" min="0" required
                           autocomplete="off" readonly onfocus="this.removeAttribute('readonly')">
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label">
                        <i class="fas fa-money-bill-wave" style="color: #00d2ff;"></i> Price (Rs.) <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text" style="background: #1a1a2e; color: #fff; border-color: #1a1a2e;">
                            <i class="fas fa-rupee-sign"></i>
                        </span>
                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                               id="price" name="price" value="{{ old('price') }}" 
                               placeholder="0.00" min="0" required
                               autocomplete="off" readonly onfocus="this.removeAttribute('readonly')">
                    </div>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="sku" class="form-label">
                        <i class="fas fa-barcode" style="color: #00d2ff;"></i> SKU (Stock Keeping Unit)
                    </label>
                    <input type="text" class="form-control @error('sku') is-invalid @enderror" 
                           id="sku" name="sku" value="{{ old('sku') }}" 
                           placeholder="e.g., PROD-001"
                           autocomplete="off" readonly onfocus="this.removeAttribute('readonly')">
                    @error('sku')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="supplier_id" class="form-label">
                        <i class="fas fa-truck" style="color: #00d2ff;"></i> Supplier
                    </label>
                    <select class="form-control @error('supplier_id') is-invalid @enderror" 
                            id="supplier_id" name="supplier_id">
                        <option value="">Select Supplier (Optional)</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" 
                                {{ old('supplier_id', request()->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('supplier_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Product
            </button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<style>
    /* Completely hide autofill background */
    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus,
    input:-webkit-autofill:active {
        -webkit-box-shadow: 0 0 0 30px white inset !important;
        -webkit-text-fill-color: #000 !important;
        transition: background-color 5000s ease-in-out 0s;
    }
    
    /* Disable autofill suggestions dropdown */
    input::-webkit-contacts-auto-fill-button {
        visibility: hidden;
        display: none !important;
        pointer-events: none;
        position: absolute;
        right: 0;
    }
    
    /* Remove autofill background on dark theme */
    .form-control:-webkit-autofill {
        background-color: transparent !important;
    }
    
    .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .form-control {
        border-radius: 8px;
    }
    .form-control:focus {
        border-color: #ff0037;
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