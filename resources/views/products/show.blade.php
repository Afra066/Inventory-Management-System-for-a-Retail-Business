@extends('layouts.app')

@section('title', 'Product Details - iPower System')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Product Details</h2>
    <div>
        @if(Auth::user()->role === 'admin')
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
        @endif
        <a href="{{ route('products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 30%;">Product ID</th>
                        <td>{{ $product->id }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td><strong>{{ $product->name }}</strong></td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td>{{ $product->category ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Quantity</th>
                        <td>
                            @if($product->quantity <= 0)
                                <span class="badge bg-danger">{{ $product->quantity }}</span>
                            @elseif($product->quantity <= 5)
                                <span class="badge bg-warning">{{ $product->quantity }}</span>
                            @else
                                <span class="badge bg-success">{{ $product->quantity }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <td>Rs. {{ number_format($product->price, 2) }}</td>
                    </tr>
                    <tr>
                        <th>SKU</th>
                        <td>{{ $product->sku ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Supplier</th>
                        <td>{{ $product->supplier->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $product->created_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                    <tr>
                        <th>Last Updated</th>
                        <td>{{ $product->updated_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0"><i class="fas fa-info-circle"></i> Quick Info</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <h5>Stock Status</h5>
                        @if($product->quantity <= 0)
                            <span class="badge bg-danger" style="font-size: 20px;">Out of Stock</span>
                        @elseif($product->quantity <= 5)
                            <span class="badge bg-warning" style="font-size: 20px;">Low Stock</span>
                        @else
                            <span class="badge bg-success" style="font-size: 20px;">In Stock</span>
                        @endif
                    </div>
                    <div class="col-6">
                        <h5>Total Value</h5>
                        <h4 class="text-primary">Rs. {{ number_format($product->quantity * $product->price, 2) }}</h4>
                    </div>
                </div>
                <hr>
                <div class="d-grid gap-2">
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Product
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection