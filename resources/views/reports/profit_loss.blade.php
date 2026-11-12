@extends('layouts.app')

@section('title', 'Profit & Loss Report - iPower System')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 no-print">
    <h2><i class="fas fa-chart-line" style="color: #1a1a2e;"></i> Profit & Loss Report</h2>
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
                <label class="form-label"><i class="fas fa-calendar-year"></i> Year</label>
                <select name="year" class="form-control">
                    @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                        <option value="{{ $i }}" {{ ($year ?? date('Y')) == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label"><i class="fas fa-calendar-alt"></i> Month (Optional)</label>
                <select name="month" class="form-control">
                    <option value="">Full Year</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ ($month ?? '') == $i ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                        </option>
                    @endfor
                </select>
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
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="fas fa-arrow-up"></i> Revenue</h6>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Total Revenue</th>
                            <td><strong>Rs. {{ number_format($totalRevenue ?? 0, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <th>Total Invoices</th>
                            <td>{{ $invoiceCount ?? 0 }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h6 class="mb-0"><i class="fas fa-arrow-down"></i> Expenses</h6>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Total Expenses</th>
                            <td><strong>Rs. {{ number_format($totalExpenses ?? 0, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <th>Total Entries</th>
                            <td>{{ $expenseCount ?? 0 }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-3">
            <div class="card">
                <div class="card-header {{ ($netProfit ?? 0) >= 0 ? 'bg-primary' : 'bg-danger' }} text-white">
                    <h6 class="mb-0"><i class="fas fa-chart-line"></i> Net Profit / Loss</h6>
                </div>
                <div class="card-body text-center">
                    <h2 class="{{ ($netProfit ?? 0) >= 0 ? 'text-success' : 'text-danger' }}">
                        <i class="fas fa-{{ ($netProfit ?? 0) >= 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                        Rs. {{ number_format($netProfit ?? 0, 2) }}
                    </h2>
                    <p>{{ $monthName ?? 'Full Year' }} {{ $yearName ?? date('Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div class="card mt-3 no-print">
        <div class="card-header bg-dark text-white">
            <h6 class="mb-0"><i class="fas fa-chart-bar"></i> Monthly Breakdown</h6>
        </div>
        <div class="card-body">
            <canvas id="pnlChart" height="100"></canvas>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (!window.matchMedia('print').matches) {
            const ctx = document.getElementById('pnlChart')?.getContext('2d');
            if (ctx) {
                const monthlyRevenue = @json($monthlyRevenue ?? []);
                const monthlyExpenses = @json($monthlyExpensesData ?? []);
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: months,
                        datasets: [
                            {
                                label: 'Revenue',
                                data: Object.values(monthlyRevenue),
                                backgroundColor: 'rgba(40, 167, 69, 0.7)',
                                borderColor: '#28a745',
                                borderWidth: 1
                            },
                            {
                                label: 'Expenses',
                                data: Object.values(monthlyExpenses),
                                backgroundColor: 'rgba(220, 53, 69, 0.7)',
                                borderColor: '#dc3545',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'Rs. ' + value;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }
    });
</script>

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
        body {
            margin: 0 !important;
            padding: 10px !important;
        }
    }
</style>
@endsection