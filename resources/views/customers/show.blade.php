@extends('layouts.app')

@section('title', 'Customer Details - iPower System')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Customer Details</h2>
    <div>
        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 30%;">Customer ID</th>
                        <td>{{ $customer->id }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td><strong>{{ $customer->name }}</strong></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $customer->email ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{ $customer->phone ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ $customer->address ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Created By</th>
                        <td>{{ $customer->user->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $customer->created_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                    <tr>
                        <th>Last Updated</th>
                        <td>{{ $customer->updated_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0"><i class="fas fa-file-invoice"></i> Customer Invoices</h6>
            </div>
            <div class="card-body">
                @if($customer->invoices->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customer->invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->invoice_number }}</td>
                                    <td>Rs. {{ number_format($invoice->total_amount, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $invoice->payment_status == 'paid' ? 'success' : 'warning' }}">
                                            {{ ucfirst($invoice->payment_status) }}
                                        </span>
                                    </td>
                                    <td>{{ $invoice->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted my-3">No invoices found for this customer.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection