@extends('layouts.app')

@section('title', 'Invoices - iPower System')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-file-invoice" style="color: #00d2ff;"></i> Invoices</h2>
    @if(in_array(Auth::user()->role, ['admin', 'accountant']))
        <a href="{{ route('invoices.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Create Invoice
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
                        <th style="width: 15%;">Invoice #</th>
                        <th style="width: 15%;">Customer</th>
                        <th style="width: 15%;">Total Amount</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 12%;">Created By</th>
                        <th style="width: 10%;">Date</th>
                        <th style="width: 18%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $index => $invoice)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td><strong>{{ $invoice->invoice_number }}</strong></td>
                            <td>{{ $invoice->customer->name ?? 'N/A' }}</td>
                            <td>Rs. {{ number_format($invoice->total_amount, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $invoice->payment_status == 'paid' ? 'success' : ($invoice->payment_status == 'pending' ? 'warning' : 'info') }}" style="font-size: 13px;">
                                    @if($invoice->payment_status == 'paid')
                                        <i class="fas fa-check-circle"></i> Paid
                                    @elseif($invoice->payment_status == 'pending')
                                        <i class="fas fa-clock"></i> Pending
                                    @else
                                        <i class="fas fa-hourglass-half"></i> Partial
                                    @endif
                                </span>
                            </td>
                            <td>{{ $invoice->user->name ?? 'N/A' }}</td>
                            <td>{{ $invoice->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(in_array(Auth::user()->role, ['admin', 'accountant']))
                                        <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-warning" title="Edit Status">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this invoice?')" title="Delete">
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
                                <i class="fas fa-file-invoice" style="font-size: 40px; color: #6c757d; display: block; margin-bottom: 10px;"></i>
                                No invoices found. 
                                @if(in_array(Auth::user()->role, ['admin', 'accountant']))
                                    <a href="{{ route('invoices.create') }}">Create your first invoice</a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mt-3">
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6 class="mb-0"><i class="fas fa-money-bill-wave"></i> Total Revenue</h6>
                <h3><i class="fas fa-rupee-sign"></i> {{ number_format($invoices->sum('total_amount'), 2) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6 class="mb-0"><i class="fas fa-file-invoice"></i> Total Invoices</h6>
                <h3>{{ $invoices->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h6 class="mb-0"><i class="fas fa-clock"></i> Pending Payments</h6>
                <h3>{{ $invoices->where('payment_status', 'pending')->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6 class="mb-0"><i class="fas fa-check-circle"></i> Paid Invoices</h6>
                <h3>{{ $invoices->where('payment_status', 'paid')->count() }}</h3>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-group .btn {
        border-radius: 4px !important;
        margin: 0 2px;
    }
    .table th {
        font-weight: 600;
        font-size: 12px;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        vertical-align: middle;
    }
    .table td {
        font-size: 14px;
        vertical-align: middle;
    }
    .badge {
        font-size: 13px;
        padding: 5px 12px;
    }
</style>
@endsection