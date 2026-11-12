@extends('layouts.app')

@section('title', 'Stock Report - iPower System')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 no-print">
    <h2><i class="fas fa-boxes" style="color: #1a1a2e;"></i> Stock Report</h2>
    <div>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <a href="#" class="btn btn-primary" onclick="window.print()">
            <i class="fas fa-print"></i> Print
        </a>
    </div>
</div>

<!-- Summary Cards - Hidden when printing -->
<div class="row mb-3 no-print">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6><i class="fas fa-boxes"></i> Total Products</h6>
                <h3>{{ $totalProducts ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h6><i class="fas fa-exclamation-triangle"></i> Low Stock (≤ 5)</h6>
                <h3>{{ $lowStock ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h6><i class="fas fa-times-circle"></i> Out of Stock (≤ 0)</h6>
                <h3>{{ $outOfStock ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6><i class="fas fa-check-circle"></i> In Stock (&gt; 5)</h6>
                <h3>{{ ($totalProducts ?? 0) - ($lowStock ?? 0) }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Printable Area - Only Table -->
<div id="printArea">
    <!-- Report Header (Visible only in print) -->
    <div class="print-header" style="display: none;">
        <h2 style="text-align: center; margin-bottom: 20px; color: #1a1a2e;">
            <i class="fas fa-boxes" style="color: #00d2ff;"></i> Stock Report
        </h2>
        <hr style="border: 1px solid #1a1a2e; margin-bottom: 20px;">
    </div>

    <div class="card">
        <div class="card-header bg-dark text-white no-print">
            <h6 class="mb-0"><i class="fas fa-list"></i> Product Stock List</h6>
        </div>
        <!-- Print Header for Table -->
        <div class="print-table-header" style="display: none; text-align: center; margin-bottom: 15px;">
            <h4 style="color: #1a1a2e;">Product Stock List</h4>
            <p style="color: #6c757d; font-size: 12px;">Generated on: {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Supplier</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products ?? [] as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $product->name ?? 'N/A' }}</strong></td>
                                <td>{{ $product->category ?? 'N/A' }}</td>
                                <td>
                                    @if(($product->quantity ?? 0) <= 0)
                                        <span class="badge bg-danger">{{ $product->quantity ?? 0 }}</span>
                                    @elseif(($product->quantity ?? 0) <= 5)
                                        <span class="badge bg-warning">{{ $product->quantity ?? 0 }}</span>
                                    @else
                                        <span class="badge bg-success">{{ $product->quantity ?? 0 }}</span>
                                    @endif
                                </td>
                                <td>Rs. {{ number_format($product->price ?? 0, 2) }}</td>
                                <td>{{ $product->supplier_name ?? 'N/A' }}</td>
                                <td>
                                    @if(($product->quantity ?? 0) <= 0)
                                        <span class="badge bg-danger">Out of Stock</span>
                                    @elseif(($product->quantity ?? 0) <= 5)
                                        <span class="badge bg-warning">Low Stock</span>
                                    @else
                                        <span class="badge bg-success">In Stock</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Report Footer (Visible only in print) -->
    <div class="print-footer" style="display: none; text-align: center; margin-top: 20px; padding-top: 15px; border-top: 1px solid #dee2e6;">
        <p style="color: #6c757d; font-size: 12px;">
            <i class="fas fa-clock"></i> Report generated on: {{ now()->format('d/m/Y H:i:s') }}
        </p>
        <p style="color: #6c757d; font-size: 11px;">
            iPower System - Inventory Management Software
        </p>
    </div>
</div>

<style>
    /* Print Styles */
    @media print {
        /* Hide sidebar, navbar, buttons, summary cards */
        .sidebar, .navbar, .no-print, .btn, .main-content .no-print {
            display: none !important;
        }
        
        /* Show only print area */
        #printArea {
            display: block !important;
            margin: 0 !important;
            padding: 10px !important;
            width: 100% !important;
        }
        
        /* Show print header and footer */
        .print-header, .print-table-header, .print-footer {
            display: block !important;
        }
        
        /* Remove card shadows and borders */
        .card {
            box-shadow: none !important;
            border: 1px solid #dee2e6 !important;
        }
        
        /* Table borders */
        .table-bordered {
            border: 1px solid #000 !important;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #000 !important;
        }
        
        /* Table header */
        thead th {
            background-color: #1a1a2e !important;
            color: #fff !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        
        /* Badge colors for print */
        .badge {
            border: 1px solid #000 !important;
            background-color: #fff !important;
            color: #000 !important;
        }
        
        .badge.bg-success {
            background-color: #d4edda !important;
            color: #155724 !important;
            border-color: #155724 !important;
        }
        .badge.bg-warning {
            background-color: #fff3cd !important;
            color: #856404 !important;
            border-color: #856404 !important;
        }
        .badge.bg-danger {
            background-color: #f8d7da !important;
            color: #721c24 !important;
            border-color: #721c24 !important;
        }
        
        /* Body margin */
        body {
            margin: 0 !important;
            padding: 10px !important;
        }
        
        /* Hide card header in print */
        .card-header {
            display: none !important;
        }
    }
</style>
@endsection