@extends('layouts.app')

@section('title', 'Accountant Dashboard - iPower System')

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1" style="color: #1a1a2e;">Accountant Dashboard</h4>
        <small style="color: #6c757d;">Financial Management Overview</small>
    </div>
    <div class="d-flex align-items-center">
        <span class="badge bg-warning me-2">Accountant</span>
        <span class="badge bg-secondary">{{ Auth::user()->name }}</span>
    </div>
</div>

<!-- Welcome Message -->
<div class="alert alert-primary d-flex justify-content-between align-items-center" style="border-left: 4px solid #00d2ff;">
    <div>
        <i class="fas fa-user-circle me-2" style="font-size: 20px;"></i>
        <strong>Welcome {{ Auth::user()->name }}!</strong> You can manage financial records, expenses, and reports.
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
                        <div class="stat-label" style="font-size: 13px; opacity: 0.8;">Total Customers</div>
                        <div class="stat-number" style="font-size: 28px; font-weight: 700;">{{ \App\Models\Customer::count() }}</div>
                    </div>
                    <div class="stat-icon" style="font-size: 35px; opacity: 0.4;">
                        <i class="fas fa-users"></i>
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
                        <div class="stat-label" style="font-size: 13px; opacity: 0.8;">Total Suppliers</div>
                        <div class="stat-number" style="font-size: 28px; font-weight: 700;">{{ \App\Models\Supplier::count() }}</div>
                    </div>
                    <div class="stat-icon" style="font-size: 35px; opacity: 0.4;">
                        <i class="fas fa-truck"></i>
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
                        <div class="stat-label" style="font-size: 13px; opacity: 0.8;">Total Expenses</div>
                        <div class="stat-number" style="font-size: 28px; font-weight: 700;">Rs. {{ number_format(\App\Models\Expense::sum('amount'), 2) }}</div>
                    </div>
                    <div class="stat-icon" style="font-size: 35px; opacity: 0.4;">
                        <i class="fas fa-money-bill-wave"></i>
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
                        <div class="stat-label" style="font-size: 13px; opacity: 0.8;">Total Revenue</div>
                        <div class="stat-number" style="font-size: 28px; font-weight: 700;">Rs. {{ number_format(\App\Models\Invoice::sum('total_amount'), 2) }}</div>
                    </div>
                    <div class="stat-icon" style="font-size: 35px; opacity: 0.4;">
                        <i class="fas fa-chart-line"></i>
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
                    <a href="{{ route('suppliers.create') }}" class="btn btn-info btn-sm" style="border-radius: 8px; color: #fff;">
                        <i class="fas fa-truck"></i> Add Supplier
                    </a>
                    <a href="{{ route('expenses.create') }}" class="btn btn-danger btn-sm" style="border-radius: 8px;">
                        <i class="fas fa-money-bill"></i> Add Expense
                    </a>
                    <a href="{{ route('customers.create') }}" class="btn btn-success btn-sm" style="border-radius: 8px;">
                        <i class="fas fa-user-plus"></i> Add Customer
                    </a>
                    <a href="{{ route('reports.index') }}" class="btn btn-warning btn-sm" style="border-radius: 8px;">
                        <i class="fas fa-chart-bar"></i> Generate Report
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row g-3">
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
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentExpenses as $expense)
                                <tr>
                                    <td>{{ $expense->description }}</td>
                                    <td>{{ $expense->category ?? 'N/A' }}</td>
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

    <!-- Recent Invoices -->
    <div class="col-md-6">
        <div class="card" style="border-radius: 12px; border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <div class="card-header bg-white" style="border-radius: 12px 12px 0 0; border-bottom: 1px solid #f0f0f0;">
                <h6 class="mb-0"><i class="fas fa-file-invoice me-2" style="color: #4facfe;"></i> Recent Invoices</h6>
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

    <!-- Financial Summary -->
    <div class="col-12">
        <div class="card" style="border-radius: 12px; border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <div class="card-header bg-white" style="border-radius: 12px 12px 0 0; border-bottom: 1px solid #f0f0f0;">
                <h6 class="mb-0"><i class="fas fa-chart-pie me-2" style="color: #00d2ff;"></i> Financial Summary</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-6">
                        <p class="mb-1"><small class="text-muted">Total Revenue</small></p>
                        <h5 style="color: #28a745;">Rs. {{ number_format(\App\Models\Invoice::sum('total_amount'), 2) }}</h5>
                    </div>
                    <div class="col-md-3 col-6">
                        <p class="mb-1"><small class="text-muted">Total Expenses</small></p>
                        <h5 style="color: #dc3545;">Rs. {{ number_format(\App\Models\Expense::sum('amount'), 2) }}</h5>
                    </div>
                    <div class="col-md-3 col-6">
                        <p class="mb-1"><small class="text-muted">Net Profit</small></p>
                        @php
                            $totalRevenue = \App\Models\Invoice::sum('total_amount');
                            $totalExpenses = \App\Models\Expense::sum('amount');
                            $netProfit = $totalRevenue - $totalExpenses;
                            $profitColor = $netProfit >= 0 ? 'text-success' : 'text-danger';
                        @endphp
                        <h5 class="{{ $profitColor }}">Rs. {{ number_format($netProfit, 2) }}</h5>
                    </div>
                    <div class="col-md-3 col-6">
                        <p class="mb-1"><small class="text-muted">Total Invoices</small></p>
                        <h5 style="color: #4facfe;">{{ \App\Models\Invoice::count() }}</h5>
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