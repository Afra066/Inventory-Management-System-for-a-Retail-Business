@extends('layouts.app')

@section('title', 'Sales Staff Dashboard - iPower System')

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1" style="color: #1a1a2e;">Sales Staff Dashboard</h4>
        <small style="color: #6c757d;">Sales Management Overview</small>
    </div>
    <div class="d-flex align-items-center">
        <span class="badge bg-secondary me-2">Sales Staff</span>
        <span class="badge bg-secondary">{{ Auth::user()->name }}</span>
    </div>
</div>

<!-- Welcome Message -->
<div class="alert alert-info d-flex justify-content-between align-items-center" style="border-left: 4px solid #00d2ff;">
    <div>
        <i class="fas fa-user-circle me-2" style="font-size: 20px;"></i>
        <strong>Welcome {{ Auth::user()->name }}!</strong> You can view products and manage customers.
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-4 col-sm-6">
        <div class="card stat-card bg-gradient-blue" style="border-radius: 12px; border: none;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label" style="font-size: 13px; opacity: 0.8;">Products In Stock</div>
                        <div class="stat-number" style="font-size: 28px; font-weight: 700;">
                            {{ \App\Models\Product::where('quantity', '>', 0)->count() }}
                        </div>
                    </div>
                    <div class="stat-icon" style="font-size: 35px; opacity: 0.4;">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6">
        <div class="card stat-card bg-gradient-orange" style="border-radius: 12px; border: none;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label" style="font-size: 13px; opacity: 0.8;">Out of Stock</div>
                        <div class="stat-number" style="font-size: 28px; font-weight: 700;">
                            {{ \App\Models\Product::where('quantity', '<=', 0)->count() }}
                        </div>
                    </div>
                    <div class="stat-icon" style="font-size: 35px; opacity: 0.4;">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6">
        <div class="card stat-card bg-gradient-green" style="border-radius: 12px; border: none;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label" style="font-size: 13px; opacity: 0.8;">My Customers</div>
                        <div class="stat-number" style="font-size: 28px; font-weight: 700;">
                            {{ \App\Models\Customer::where('created_by', Auth::id())->count() }}
                        </div>
                    </div>
                    <div class="stat-icon" style="font-size: 35px; opacity: 0.4;">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Action Buttons -->
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="card" style="border-radius: 12px; border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    <h6 class="me-3" style="color: #6c757d; line-height: 38px;">Quick Actions:</h6>
                    <a href="{{ route('customers.create') }}" class="btn btn-success btn-sm" style="border-radius: 8px;">
                        <i class="fas fa-user-plus"></i> Add Customer
                    </a>
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm" style="border-radius: 8px;">
                        <i class="fas fa-box"></i> View Products
                    </a>
                    <!-- View Invoices removed -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Products List with Stock Status -->
<div class="row">
    <div class="col-12">
        <div class="card" style="border-radius: 12px; border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <div class="card-header bg-white" style="border-radius: 12px 12px 0 0; border-bottom: 1px solid #f0f0f0;">
                <h6 class="mb-0"><i class="fas fa-boxes me-2" style="color: #00d2ff;"></i> Products Stock Status</h6>
            </div>
            <div class="card-body">
                @php $products = \App\Models\Product::orderBy('quantity', 'asc')->get(); @endphp
                @if($products->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td><strong>{{ $product->name }}</strong></td>
                                    <td>{{ $product->category ?? 'N/A' }}</td>
                                    <td>
                                        @if($product->quantity > 0)
                                            <span class="badge bg-success">{{ $product->quantity }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $product->quantity }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($product->quantity > 0)
                                            <span class="badge bg-success">✅ In Stock</span>
                                        @else
                                            <span class="badge bg-danger">❌ Out of Stock</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted my-3">No products available.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-blue { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; }
    .bg-gradient-green { background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%); color: #fff; }
    .bg-gradient-orange { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: #fff; }
    
    .stat-card {
        transition: transform 0.2s;
        cursor: default;
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
    .stat-card .card-body {
        padding: 20px;
    }
    
    .btn-sm {
        padding: 6px 16px;
        font-size: 13px;
    }
    
    .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .card-header {
        background: #fff;
        border-bottom: 1px solid #f0f0f0;
        padding: 15px 20px;
    }
    
    .table th {
        font-weight: 600;
        font-size: 12px;
        color: #6c757d;
        border-top: none;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .table td {
        font-size: 14px;
        vertical-align: middle;
    }
    
    .alert {
        border-radius: 12px;
        border: none;
    }
</style>
@endsection