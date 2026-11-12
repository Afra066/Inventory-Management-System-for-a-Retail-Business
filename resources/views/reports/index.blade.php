@extends('layouts.app')

@section('title', 'Reports - iPower System')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-chart-bar" style="color: #1a1a2e;"></i> Reports Dashboard</h2>
</div>

<!-- Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h6 class="card-title"><i class="fas fa-money-bill-wave"></i> Today's Sales</h6>
                <h3>Rs. {{ number_format($todaySales ?? 0, 2) }}</h3>
                <small>{{ $todayCount ?? 0 }} invoices</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h6 class="card-title"><i class="fas fa-calendar-alt"></i> Monthly Sales</h6>
                <h3>Rs. {{ number_format($monthlySales ?? 0, 2) }}</h3>
                <small>{{ $monthlyCount ?? 0 }} invoices</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h6 class="card-title"><i class="fas fa-chart-line"></i> Total Revenue</h6>
                <h3>Rs. {{ number_format($totalRevenue ?? 0, 2) }}</h3>
                <small>{{ $totalInvoices ?? 0 }} invoices</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h6 class="card-title"><i class="fas fa-file-invoice"></i> Net Profit</h6>
                <h3 class="{{ ($netProfit ?? 0) >= 0 ? 'text-white' : 'text-danger' }}">Rs. {{ number_format($netProfit ?? 0, 2) }}</h3>
                <small>Revenue - Expenses</small>
            </div>
        </div>
    </div>
</div>

<!-- Report Links -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h6 class="mb-0"><i class="fas fa-file-alt"></i> Generate Reports</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <a href="{{ route('reports.daily-sales') }}" class="btn btn-primary w-100">
                            <i class="fas fa-calendar-day"></i> Daily Sales
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('reports.monthly-sales') }}" class="btn btn-success w-100">
                            <i class="fas fa-calendar-alt"></i> Monthly Sales
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('reports.profit-loss') }}" class="btn btn-warning w-100">
                            <i class="fas fa-chart-line"></i> Profit & Loss
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('reports.expenses') }}" class="btn btn-danger w-100">
                            <i class="fas fa-money-bill-wave"></i> Expense Report
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('reports.stock') }}" class="btn btn-info w-100">
                            <i class="fas fa-boxes"></i> Stock Report
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .btn {
        border-radius: 8px;
        padding: 10px;
    }
</style>
@endsection