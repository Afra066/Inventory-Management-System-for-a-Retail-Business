@extends('layouts.app')

@section('title', 'Expense Report - iPower System')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 no-print">
    <h2><i class="fas fa-money-bill-wave" style="color: #1a1a2e;"></i> Expense Report</h2>
    <div>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <a href="#" class="btn btn-primary" onclick="window.print()">
            <i class="fas fa-print"></i> Print
        </a>
    </div>
</div>

<div class="card mb-3 no-print">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label"><i class="fas fa-calendar-alt"></i> Start Date</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate ?? date('Y-m-01') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label"><i class="fas fa-calendar-alt"></i> End Date</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate ?? date('Y-m-d') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Generate
                </button>
            </div>
        </form>
    </div>
</div>

<div id="printArea">
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="alert alert-danger">
                <i class="fas fa-money-bill-wave"></i> 
                <strong>Total Expenses:</strong> Rs. {{ number_format($totalExpenses ?? 0, 2) }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="alert alert-info">
                <i class="fas fa-list"></i> 
                <strong>Total Entries:</strong> {{ $totalCount ?? 0 }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="alert alert-warning">
                <i class="fas fa-calculator"></i> 
                <strong>Average Expense:</strong> Rs. {{ ($totalCount ?? 0) > 0 ? number_format(($totalExpenses ?? 0) / $totalCount, 2) : '0.00' }}
            </div>
        </div>
    </div>

    <!-- Category Breakdown -->
    <div class="card mb-3">
        <div class="card-header bg-dark text-white">
            <h6 class="mb-0"><i class="fas fa-chart-pie"></i> Category Breakdown</h6>
        </div>
        <div class="card-body">
            <div class="row">
                @forelse($categoryData ?? [] as $category)
                    <div class="col-md-3">
                        <div class="alert alert-secondary">
                            <i class="fas fa-tag"></i> 
                            <strong>{{ $category->category ?? 'Uncategorized' }}</strong>
                            <br>Rs. {{ number_format($category->total ?? 0, 2) }}
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">No categories found</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-dark text-white">
            <h6 class="mb-0"><i class="fas fa-list"></i> Expense List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Added By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses ?? [] as $index => $expense)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $expense->description ?? 'N/A' }}</strong></td>
                                <td>{{ $expense->category ?? 'N/A' }}</td>
                                <td><span class="badge bg-danger">Rs. {{ number_format($expense->amount ?? 0, 2) }}</span></td>
                                <td>{{ isset($expense->created_at) ? date('d/m/Y', strtotime($expense->created_at)) : 'N/A' }}</td>
                                <td>{{ $expense->user_name ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No expenses found for this period.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12 text-center" style="border-top: 1px solid #dee2e6; padding-top: 15px;">
            <p style="color: #6c757d; font-size: 12px;">
                <i class="fas fa-clock"></i> Report generated on: {{ now()->format('d/m/Y H:i:s') }}
            </p>
        </div>
    </div>
</div>

<style>
    @media print {
        .sidebar, .navbar, .no-print, .btn {
            display: none !important;
        }
        #printArea {
            display: block !important;
            padding: 10px !important;
            width: 100% !important;
        }
        .card {
            box-shadow: none !important;
            border: 1px solid #dee2e6 !important;
        }
        .table-bordered {
            border: 1px solid #000 !important;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #000 !important;
        }
        thead th {
            background-color: #1a1a2e !important;
            color: #fff !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .alert {
            border: 1px solid #000 !important;
            background-color: #fff !important;
            color: #000 !important;
        }
        .badge {
            border: 1px solid #000 !important;
            background-color: #fff !important;
            color: #000 !important;
        }
        body {
            margin: 0 !important;
            padding: 10px !important;
        }
    }
</style>
@endsection