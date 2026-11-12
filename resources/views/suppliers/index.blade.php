@extends('layouts.app')

@section('title', 'Suppliers - iPower System')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-truck" style="color: #00d2ff;"></i> Suppliers</h2>
    <a href="{{ route('suppliers.create') }}" class="btn btn-primary">
        <i class="fas fa-plus-circle"></i> Add Supplier
    </a>
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
                        <th style="width: 15%;">Name</th>
                        <th style="width: 15%;">Email</th>
                        <th style="width: 12%;">Phone</th>
                        <th style="width: 20%;">Address</th>
                        <th style="width: 15%;">Payment Due</th>
                        <th style="width: 18%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $index => $supplier)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td><strong>{{ $supplier->name }}</strong></td>
                            <td>{{ $supplier->email ?? 'N/A' }}</td>
                            <td>{{ $supplier->phone ?? 'N/A' }}</td>
                            <td>{{ Str::limit($supplier->address ?? 'N/A', 30) }}</td>
                            <td>
                                @if($supplier->payment_due > 0)
                                    <span class="badge bg-danger" style="font-size: 14px;">
                                        <i class="fas fa-rupee-sign"></i> {{ number_format($supplier->payment_due, 2) }}
                                    </span>
                                @else
                                    <span class="badge bg-success" style="font-size: 14px;">
                                        <i class="fas fa-check-circle"></i> Rs. 0.00
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('suppliers.show', $supplier->id) }}" class="btn btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this supplier?')" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-truck" style="font-size: 40px; color: #6c757d; display: block; margin-bottom: 10px;"></i>
                                No suppliers found. <a href="{{ route('suppliers.create') }}">Add your first supplier</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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