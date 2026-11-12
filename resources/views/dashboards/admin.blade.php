@extends('layouts.app')

@section('title', 'Admin Dashboard - iPower System')

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1" style="color: #1a1a2e;">Admin Dashboard</h4>
        <small style="color: #6c757d;">Inventory Management System</small>
    </div>
    <div class="d-flex align-items-center">
        <span class="badge bg-danger me-2">Admin</span>
        <span class="badge bg-secondary">{{ Auth::user()->name }}</span>
    </div>
</div>

<!-- Welcome Message -->
<div class="alert alert-info d-flex justify-content-between align-items-center" style="border-left: 4px solid #00d2ff;">
    <div>
        <i class="fas fa-user-circle me-2" style="font-size: 20px;"></i>
        <strong>Welcome {{ Auth::user()->name }}!</strong> You have full access to all system features.
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card stat-card bg-gradient-blue" style="border-radius: 12px; border: none;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label" style="font-size: 13px; opacity: 0.8;">Total Employees</div>
                        <div class="stat-number" style="font-size: 28px; font-weight: 700;">{{ \App\Models\User::count() }}</div>
                    </div>
                    <div class="stat-icon" style="font-size: 35px; opacity: 0.4;">
                        <i class="fas fa-users-cog"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card stat-card bg-gradient-green" style="border-radius: 12px; border: none;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label" style="font-size: 13px; opacity: 0.8;">Total Products</div>
                        <div class="stat-number" style="font-size: 28px; font-weight: 700;">{{ \App\Models\Product::count() ?? 0 }}</div>
                    </div>
                    <div class="stat-icon" style="font-size: 35px; opacity: 0.4;">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card stat-card bg-gradient-orange" style="border-radius: 12px; border: none;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label" style="font-size: 13px; opacity: 0.8;">Total Customers</div>
                        <div class="stat-number" style="font-size: 28px; font-weight: 700;">{{ \App\Models\Customer::count() ?? 0 }}</div>
                    </div>
                    <div class="stat-icon" style="font-size: 35px; opacity: 0.4;">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card stat-card bg-gradient-cyan" style="border-radius: 12px; border: none;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label" style="font-size: 13px; opacity: 0.8;">Total Invoices</div>
                        <div class="stat-number" style="font-size: 28px; font-weight: 700;">{{ \App\Models\Invoice::count() ?? 0 }}</div>
                    </div>
                    <div class="stat-icon" style="font-size: 35px; opacity: 0.4;">
                        <i class="fas fa-file-invoice"></i>
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
                    <a href="{{ route('users.create') }}" class="btn btn-dark btn-sm" style="border-radius: 8px;">
                        <i class="fas fa-user-plus"></i> Add Employee
                    </a>
                    <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm" style="border-radius: 8px;">
                        <i class="fas fa-plus"></i> Add Product
                    </a>
                    <a href="{{ route('customers.create') }}" class="btn btn-success btn-sm" style="border-radius: 8px;">
                        <i class="fas fa-user-plus"></i> Add Customer
                    </a>
                    <a href="{{ route('invoices.create') }}" class="btn btn-warning btn-sm" style="border-radius: 8px;">
                        <i class="fas fa-file-invoice"></i> Create Invoice
                    </a>
                    <a href="{{ route('suppliers.create') }}" class="btn btn-info btn-sm" style="border-radius: 8px; color: #fff;">
                        <i class="fas fa-truck"></i> Add Supplier
                    </a>
                    <a href="{{ route('expenses.create') }}" class="btn btn-danger btn-sm" style="border-radius: 8px;">
                        <i class="fas fa-money-bill"></i> Add Expense
                    </a>
                    <a href="{{ route('reports.index') }}" class="btn btn-secondary btn-sm" style="border-radius: 8px;">
                        <i class="fas fa-chart-bar"></i> Reports
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity Section -->
<div class="row g-3">
    <!-- Recent Invoices -->
    <div class="col-md-6">
        <div class="card" style="border-radius: 12px; border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <div class="card-header bg-white" style="border-radius: 12px 12px 0 0; border-bottom: 1px solid #f0f0f0;">
                <h6 class="mb-0"><i class="fas fa-clock me-2" style="color: #00d2ff;"></i> Recent Invoices</h6>
            </div>
            <div class="card-body">
                @php $recentInvoices = \App\Models\Invoice::with('customer')->latest()->take(5)->get(); @endphp
                @if($recentInvoices->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentInvoices as $invoice)
                                <tr>
                                    <td><strong>{{ $invoice->invoice_number }}</strong></td>
                                    <td>{{ $invoice->customer->name ?? 'N/A' }}</td>
                                    <td>Rs. {{ number_format($invoice->total_amount, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $invoice->payment_status == 'paid' ? 'success' : ($invoice->payment_status == 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($invoice->payment_status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted my-3">No invoices yet</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Expenses -->
    <div class="col-md-6">
        <div class="card" style="border-radius: 12px; border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <div class="card-header bg-white" style="border-radius: 12px 12px 0 0; border-bottom: 1px solid #f0f0f0;">
                <h6 class="mb-0"><i class="fas fa-money-bill-wave me-2" style="color: #f5576c;"></i> Recent Expenses</h6>
            </div>
            <div class="card-body">
                @php $recentExpenses = \App\Models\Expense::latest()->take(5)->get(); @endphp
                @if($recentExpenses->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentExpenses as $expense)
                                <tr>
                                    <td>{{ $expense->description }}</td>
                                    <td>Rs. {{ number_format($expense->amount, 2) }}</td>
                                    <td>{{ $expense->expense_date ?? $expense->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted my-3">No expenses recorded</p>
                @endif
            </div>
        </div>
    </div>

    <!-- System Info -->
    <div class="col-md-6">
        <div class="card" style="border-radius: 12px; border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <div class="card-header bg-white" style="border-radius: 12px 12px 0 0; border-bottom: 1px solid #f0f0f0;">
                <h6 class="mb-0"><i class="fas fa-info-circle me-2" style="color: #4facfe;"></i> System Information</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <p class="mb-1"><small class="text-muted">System Name</small></p>
                        <p><strong>iPower System</strong></p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1"><small class="text-muted">Version</small></p>
                        <p><strong>v1.0.0</strong></p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1"><small class="text-muted">Logged In As</small></p>
                        <p><strong>{{ Auth::user()->name }}</strong></p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1"><small class="text-muted">Total Employees</small></p>
                        <p><strong>{{ \App\Models\User::count() }}</strong></p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1"><small class="text-muted">Total Suppliers</small></p>
                        <p><strong>{{ \App\Models\Supplier::count() }}</strong></p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1"><small class="text-muted">Total Revenue</small></p>
                        <p><strong>Rs. {{ number_format(\App\Models\Invoice::sum('total_amount'), 2) }}</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-blue { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; }
    .bg-gradient-green { background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%); color: #fff; }
    .bg-gradient-orange { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: #fff; }
    .bg-gradient-cyan { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: #fff; }
    
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