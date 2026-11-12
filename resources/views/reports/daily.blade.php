@extends('layouts.app')

@section('title', 'Daily Sales Report - iPower System')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 no-print">
    <h2><i class="fas fa-calendar-day" style="color: #1a1a2e;"></i> Daily Sales Report</h2>
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
            <div class="col-md-4">
                <label class="form-label"><i class="fas fa-calendar-alt"></i> Select Date</label>
                <input type="date" name="date" class="form-control" value="{{ $date }}">
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
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h6 class="mb-0"><i class="fas fa-chart-bar"></i> Sales Summary - {{ date('d/m/Y', strtotime($date)) }}
            </h6>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="alert alert-success">
                        <i class="fas fa-money-bill-wave"></i> 
                        <strong>Total Sales:</strong> Rs. {{ number_format($totalSales ?? 0, 2) }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="alert alert-info">
                        <i class="fas fa-file-invoice"></i> 
                        <strong>Total Invoices:</strong> {{ $totalCount ?? 0 }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="alert alert-warning">
                        <i class="fas fa-calculator"></i> 
                        <strong>Average Sale:</strong> Rs. {{ ($totalCount ?? 0) > 0 ? number_format(($totalSales ?? 0) / $totalCount, 2) : '0.00' }}
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Invoice #</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices ?? [] as $index => $invoice)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $invoice->invoice_number ?? 'N/A' }}</strong></td>
                                <td>{{ $invoice->customer_name ?? 'N/A' }}</td>
                                <td>Rs. {{ number_format($invoice->total_amount ?? 0, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $invoice->payment_status == 'paid' ? 'success' : ($invoice->payment_status == 'pending' ? 'warning' : 'info') }}">
                                        {{ ucfirst($invoice->payment_status ?? 'N/A') }}
                                    </span>
                                </td>
                                <td>{{ $invoice->user_name ?? 'N/A' }}</td>
                                <td>{{ isset($invoice->created_at) ? date('H:i:s', strtotime($invoice->created_at)) : 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No sales found for this date.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="row mt-4">
                <div class="col-12 text-center" style="border-top: 1px solid #dee2e6; padding-top: 15px;">
                    <p style="color: #6c757d; font-size: 12px;">
                        <i class="fas fa-clock"></i> Report generated on: {{ now()->format('d/m/Y H:i:s') }}
                    </p>
                </div>
            </div>
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
        body {
            margin: 0 !important;
            padding: 10px !important;
        }
    }
</style>
@endsection