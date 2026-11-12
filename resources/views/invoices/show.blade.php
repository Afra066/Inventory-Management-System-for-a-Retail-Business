@extends('layouts.app')

@section('title', 'Invoice Details - iPower System')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 no-print">
    <h2>Invoice Details</h2>
    <div>
        <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Update Status
        </a>
        <a href="#" class="btn btn-primary" onclick="printInvoice()">
            <i class="fas fa-print"></i> Print Invoice
        </a>
        <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<!-- Invoice -->
<div id="printArea">
    <div class="invoice-wrapper">
        <div class="invoice-container">
            <!-- Invoice Header -->
            <div class="invoice-header">
                <div class="row">
                    <div class="col-6">
                        <h2 class="company-name">
                            <i class="fas fa-mobile-alt" style="color: #00d2ff;"></i> iPower <span style="color: #00d2ff;">System</span>
                        </h2>
                        <p class="company-details">
                            <strong>iPower Solutions</strong><br>
                            123, Main Street,<br>
                            Colombo 01, Sri Lanka<br>
                            Phone: +94 77 123 4567<br>
                            Email: info@ipower.com
                        </p>
                    </div>
                    <div class="col-6 text-end">
                        <h3 class="invoice-title">INVOICE</h3>
                        <p class="invoice-number">
                            <strong>INVOICE #</strong> {{ $invoice->invoice_number }}<br>
                            <strong>DATE</strong> {{ $invoice->created_at->format('d/m/Y') }}<br>
                            <strong>INVOICE DUE DATE</strong> {{ $invoice->due_date ? date('d/m/Y', strtotime($invoice->due_date)) : 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Bill To -->
            <div class="bill-to">
                <div class="row">
                    <div class="col-12">
                        <h5><strong>BILL TO:</strong></h5>
                        <p class="customer-details">
                            <strong>{{ $invoice->customer->name ?? 'N/A' }}</strong><br>
                            {{ $invoice->customer->address ?? 'N/A' }}<br>
                            {{ $invoice->customer->email ?? 'N/A' }}<br>
                            {{ $invoice->customer->phone ?? 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Invoice Items Table -->
            <div class="invoice-table">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 30%;">ITEMS</th>
                            <th style="width: 25%;">DESCRIPTION</th>
                            <th style="width: 10%;">QUANTITY</th>
                            <th style="width: 15%;">PRICE</th>
                            <th style="width: 15%;">AMOUNT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->product->name ?? 'N/A' }}</td>
                            <td>{{ $item->product->category ?? 'N/A' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rs. {{ number_format($item->price, 2) }}</td>
                            <td>Rs. {{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-end"><strong>Subtotal</strong></td>
                            <td><strong>Rs. {{ number_format($invoice->items->sum('subtotal'), 2) }}</strong></td>
                        </tr>
                        @if($invoice->discount > 0)
                        <tr>
                            <td colspan="5" class="text-end"><strong>Discount</strong></td>
                            <td><strong>- Rs. {{ number_format($invoice->discount, 2) }}</strong></td>
                        </tr>
                        @endif
                        @if($invoice->tax > 0)
                        <tr>
                            <td colspan="5" class="text-end"><strong>Tax</strong></td>
                            <td><strong>Rs. {{ number_format($invoice->tax, 2) }}</strong></td>
                        </tr>
                        @endif
                        <tr class="total-row">
                            <td colspan="5" class="text-end"><strong>TOTAL</strong></td>
                            <td><strong>Rs. {{ number_format($invoice->total_amount, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Payment Status -->
            <div class="payment-status">
                <p>
                    <strong>Payment Status:</strong> 
                    <span class="badge bg-{{ $invoice->payment_status == 'paid' ? 'success' : ($invoice->payment_status == 'pending' ? 'warning' : 'info') }}" style="font-size: 14px;">
                        {{ ucfirst($invoice->payment_status) }}
                    </span>
                </p>
                @if($invoice->notes)
                    <p><strong>Notes:</strong> {{ $invoice->notes }}</p>
                @endif
            </div>

            <!-- Footer -->
            <div class="invoice-footer">
                <p>Thank you for your business!</p>
                <p style="font-size: 12px; color: #6c757d;">
                    This is a computer-generated invoice. No signature required.
                </p>
                <p style="font-size: 11px; color: #6c757d;">
                    Generated by: {{ $invoice->user->name ?? 'N/A' }} | {{ now()->format('d/m/Y H:i:s') }}
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Styles -->
<style>
    .invoice-wrapper {
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .invoice-container {
        max-width: 100%;
        margin: 0 auto;
        background: #fff;
        padding: 20px;
    }

    .company-name {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 10px;
    }

    .company-details {
        font-size: 14px;
        color: #6c757d;
        line-height: 1.6;
        margin-bottom: 0;
    }

    .invoice-title {
        font-size: 32px;
        font-weight: 800;
        color: #1a1a2e;
        letter-spacing: 2px;
        margin-bottom: 10px;
    }

    .invoice-number {
        font-size: 14px;
        color: #6c757d;
        line-height: 1.8;
        margin-bottom: 0;
    }

    .invoice-number strong {
        color: #1a1a2e;
    }

    .bill-to {
        margin: 25px 0;
        padding: 15px 0;
        border-top: 1px solid #dee2e6;
        border-bottom: 1px solid #dee2e6;
    }

    .bill-to h5 {
        color: #1a1a2e;
        margin-bottom: 10px;
    }

    .customer-details {
        font-size: 14px;
        color: #495057;
        line-height: 1.6;
        margin-bottom: 0;
    }

    .invoice-table {
        margin: 20px 0;
    }

    .invoice-table .table {
        border: 1px solid #dee2e6;
    }

    .invoice-table .table thead th {
        background-color: #1a1a2e;
        color: #fff;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        padding: 12px;
        border: 1px solid #1a1a2e;
    }

    .invoice-table .table tbody td {
        padding: 10px 12px;
        font-size: 14px;
        border: 1px solid #dee2e6;
        vertical-align: middle;
    }

    .invoice-table .table tfoot td {
        padding: 10px 12px;
        font-size: 14px;
        border: 1px solid #dee2e6;
        font-weight: 600;
    }

    .total-row {
        background-color: #f8f9fa;
    }

    .total-row td {
        font-size: 16px !important;
    }

    .payment-status {
        margin: 20px 0;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .payment-status p {
        margin-bottom: 5px;
        font-size: 14px;
    }

    .invoice-footer {
        text-align: center;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #dee2e6;
    }

    .invoice-footer p {
        margin-bottom: 5px;
        font-size: 14px;
        color: #495057;
    }

    @media print {
        .sidebar, .navbar, .main-content .no-print, .btn, .no-print {
            display: none !important;
        }
        
        #printArea {
            display: block !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }
        
        .invoice-wrapper {
            box-shadow: none !important;
            border: none !important;
            padding: 10px !important;
        }
        
        .invoice-container {
            padding: 10px !important;
        }
        
        .invoice-table .table thead th {
            background-color: #1a1a2e !important;
            color: #fff !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        
        .total-row {
            background-color: #f8f9fa !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        
        body {
            margin: 0 !important;
            padding: 10px !important;
        }
    }
</style>

<!-- Print Script -->
<script>
    function printInvoice() {
        window.print();
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (window.location.search.includes('print=true')) {
            setTimeout(function() {
                window.print();
            }, 500);
        }
    });
</script>
@endsection