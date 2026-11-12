@extends('layouts.app')

@section('title', 'Supplier Details - iPower System')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Supplier Details</h2>
    <div>
        <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <!-- Supplier Details Column -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0"><i class="fas fa-info-circle"></i> Supplier Information</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 35%;">Supplier ID</th>
                        <td>{{ $supplier->id }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td><strong>{{ $supplier->name }}</strong></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $supplier->email ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{ $supplier->phone ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ $supplier->address ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Payment Due</th>
                        <td>
                            @if($supplier->payment_due > 0)
                                <span class="badge bg-danger" style="font-size: 16px;">Rs. {{ number_format($supplier->payment_due, 2) }}</span>
                            @else
                                <span class="badge bg-success" style="font-size: 16px;">Rs. 0.00</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $supplier->created_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                    <tr>
                        <th>Last Updated</th>
                        <td>{{ $supplier->updated_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Products from this Supplier Column -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0"><i class="fas fa-box"></i> Products from this Supplier</h6>
            </div>
            <div class="card-body">
                @if($supplier->products->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($supplier->products as $product)
                                <tr>
                                    <td><strong>{{ $product->name }}</strong></td>
                                    <td>{{ $product->category ?? 'N/A' }}</td>
                                    <td>Rs. {{ number_format($product->price, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $product->quantity <= 0 ? 'danger' : ($product->quantity <= 5 ? 'warning' : 'success') }}">
                                            {{ $product->quantity }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted my-3">
                        <i class="fas fa-box-open"></i> No products found from this supplier.
                    </p>
                @endif
            </div>
        </div>

        <!-- Quick Actions Card -->
        <div class="card mt-3">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0"><i class="fas fa-bolt"></i> Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('products.create', ['supplier_id' => $supplier->id]) }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Product from this Supplier
                    </a>
                    <a href="#" class="btn btn-info">
                        <i class="fas fa-money-bill"></i> Record Payment
                    </a>
                    <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Supplier
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table th {
        font-weight: 600;
        font-size: 13px;
        color: #495057;
        background-color: #f8f9fa;
    }
    .table td {
        font-size: 14px;
    }
    .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .card-header {
        border-radius: 12px 12px 0 0 !important;
    }
    .btn {
        border-radius: 8px;
    }
    .alert {
        border-radius: 12px;
        border: none;
    }
</style>
@endsection