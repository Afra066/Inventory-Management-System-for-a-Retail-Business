@extends('layouts.app')

@section('title', 'Products - iPower System')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-box" style="color: #00d2ff;"></i> Products</h2>
    @if(in_array(Auth::user()->role, ['admin', 'accountant']))
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Add Product
        </a>
    @endif
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 20%;">Name</th>
                        <th style="width: 15%;">Category</th>
                        <th style="width: 10%;">Quantity</th>
                        <th style="width: 15%;">Price</th>
                        <th style="width: 10%;">SKU</th>
                        <th style="width: 15%;">Supplier</th>
                        <th style="width: 10%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $index => $product)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td><strong>{{ $product->name }}</strong></td>
                            <td>{{ $product->category ?? 'N/A' }}</td>
                            <td>
                                @if($product->quantity <= 0)
                                    <span class="badge bg-danger">{{ $product->quantity }}</span>
                                @elseif($product->quantity <= 5)
                                    <span class="badge bg-warning">{{ $product->quantity }}</span>
                                @else
                                    <span class="badge bg-success">{{ $product->quantity }}</span>
                                @endif
                            </td>
                            <td>Rs. {{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->sku ?? 'N/A' }}</td>
                            <td>{{ $product->supplier->name ?? 'N/A' }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(in_array(Auth::user()->role, ['admin', 'accountant']))
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-box-open" style="font-size: 40px; color: #6c757d; display: block; margin-bottom: 10px;"></i>
                                No products found. 
                                @if(in_array(Auth::user()->role, ['admin', 'accountant']))
                                    <a href="{{ route('products.create') }}">Add your first product</a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Low Stock Alert Section (Admin + Accountant only) -->
@if(in_array(Auth::user()->role, ['admin', 'accountant']))
    @php $lowStockProducts = \App\Models\Product::where('quantity', '<=', 5)->get(); @endphp
    @if($lowStockProducts->count() > 0)
        <div class="card mt-3 border-danger">
            <div class="card-header bg-danger text-white">
                <h6 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Low Stock Alert</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lowStockProducts as $index => $product)
                                <tr class="table-warning">
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $product->name }}</strong></td>
                                    <td>{{ $product->category ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $product->quantity <= 0 ? 'danger' : 'warning' }}">
                                            {{ $product->quantity }}
                                        </span>
                                    </td>
                                    <td>Rs. {{ number_format($product->price, 2) }}</td>
                                    <td>
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> Update Stock
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endif

<style>
    .btn-group .btn {
        border-radius: 4px !important;
        margin: 0 2px;
    }
    .table th {
        font-weight: 600;
        font-size: 12px;
        color: #fff;
        border-top: none;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        vertical-align: middle;
    }
    .table td {
        font-size: 14px;
        vertical-align: middle;
    }
    .badge {
        font-size: 12px;
        padding: 5px 10px;
    }
    .btn-group-sm .btn {
        padding: 4px 8px;
        font-size: 12px;
    }
</style>
@endsection