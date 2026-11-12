@extends('layouts.app')

@section('title', 'Add New Supplier - iPower System')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-truck" style="color: #00d2ff;"></i> Add New Supplier</h2>
    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('suppliers.store') }}" method="POST" id="supplierForm">
            @csrf

            <!-- Supplier Details -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">
                        <i class="fas fa-building" style="color: #00d2ff;"></i> Supplier Name <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope" style="color: #00d2ff;"></i> Email
                    </label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">
                        <i class="fas fa-phone" style="color: #00d2ff;"></i> Phone
                    </label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                           id="phone" name="phone" value="{{ old('phone') }}" placeholder="e.g., 011-2345678">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="address" class="form-label">
                        <i class="fas fa-map-marker-alt" style="color: #00d2ff;"></i> Address
                    </label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" 
                           id="address" name="address" value="{{ old('address') }}" placeholder="e.g., 456 Business Park, Colombo">
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="payment_due" class="form-label">
                        <i class="fas fa-money-bill-wave" style="color: #00d2ff;"></i> Payment Due (Rs.)
                    </label>
                    <div class="input-group">
                        <span class="input-group-text" style="background: #1a1a2e; color: #fff; border-color: #1a1a2e;">
                            <i class="fas fa-rupee-sign"></i>
                        </span>
                        <input type="number" step="0.01" class="form-control @error('payment_due') is-invalid @enderror" 
                               id="payment_due" name="payment_due" value="{{ old('payment_due', 0) }}" min="0">
                    </div>
                    @error('payment_due')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Products Supplied by this Supplier -->
            <div class="mt-4">
                <h5><i class="fas fa-boxes" style="color: #00d2ff;"></i> Products Supplied by this Supplier</h5>
                <p class="text-muted small">Add the products that this supplier provides.</p>
                
                <div id="productItemsContainer">
                    <div class="row product-item-row mb-2">
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="products[0][name]" 
                                   placeholder="Product Name" value="{{ old('products.0.name') }}">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="products[0][category]" 
                                   placeholder="Category" value="{{ old('products.0.category') }}">
                        </div>
                        <div class="col-md-2">
                            <input type="number" step="0.01" class="form-control" name="products[0][price]" 
                                   placeholder="Price" value="{{ old('products.0.price') }}" min="0">
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control" name="products[0][quantity]" 
                                   placeholder="Stock" value="{{ old('products.0.quantity', 0) }}" min="0">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger remove-product-item" disabled>
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <button type="button" id="addProductItemBtn" class="btn btn-success btn-sm mt-2">
                    <i class="fas fa-plus"></i> Add Product
                </button>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Supplier
                </button>
                <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<style>
    .product-item-row {
        background: #f8f9fa;
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 10px;
        align-items: center;
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
        border-color: #00d2ff;
        box-shadow: 0 0 0 0.2rem rgba(0, 210, 255, 0.25);
    }
    .input-group-text {
        border-radius: 8px 0 0 8px;
    }
    .btn {
        border-radius: 8px;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let productIndex = 1;

    // Add product item row
    document.getElementById('addProductItemBtn').addEventListener('click', function() {
        const container = document.getElementById('productItemsContainer');
        const newRow = document.createElement('div');
        newRow.className = 'row product-item-row mb-2';
        newRow.innerHTML = `
            <div class="col-md-4">
                <input type="text" class="form-control" name="products[${productIndex}][name]" 
                       placeholder="Product Name">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="products[${productIndex}][category]" 
                       placeholder="Category">
            </div>
            <div class="col-md-2">
                <input type="number" step="0.01" class="form-control" name="products[${productIndex}][price]" 
                       placeholder="Price" min="0">
            </div>
            <div class="col-md-2">
                <input type="number" class="form-control" name="products[${productIndex}][quantity]" 
                       placeholder="Stock" min="0" value="0">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger remove-product-item">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        container.appendChild(newRow);
        productIndex++;
        
        // Enable remove button for all rows
        document.querySelectorAll('.remove-product-item').forEach(btn => {
            btn.disabled = false;
        });
        
        attachProductEvents(newRow);
    });

    // Attach events to product row
    function attachProductEvents(row) {
        const removeBtn = row.querySelector('.remove-product-item');
        removeBtn.addEventListener('click', function() {
            const container = document.getElementById('productItemsContainer');
            if (container.children.length > 1) {
                row.remove();
                // Disable remove button if only one row left
                if (container.children.length === 1) {
                    document.querySelector('.remove-product-item').disabled = true;
                }
            } else {
                alert('You need at least one product item.');
            }
        });
    }

    // Attach events to initial row
    attachProductEvents(document.querySelector('.product-item-row'));
});
</script>
@endsection