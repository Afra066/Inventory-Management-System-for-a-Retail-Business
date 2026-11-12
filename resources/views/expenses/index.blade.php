@extends('layouts.app')

@section('title', 'Expenses - iPower System')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-money-bill-wave" style="color: #00d2ff;"></i> Expenses</h2>
    <a href="{{ route('expenses.create') }}" class="btn btn-primary">
        <i class="fas fa-plus-circle"></i> Add Expense
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
                        <th style="width: 20%;">Description</th>
                        <th style="width: 15%;">Category</th>
                        <th style="width: 15%;">Amount</th>
                        <th style="width: 12%;">Date</th>
                        <th style="width: 15%;">Added By</th>
                        <th style="width: 18%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $index => $expense)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td><strong>{{ $expense->description }}</strong></td>
                            <td>
                                <span class="badge bg-secondary">{{ $expense->category ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <span class="badge bg-danger" style="font-size: 14px;">
                                    <i class="fas fa-rupee-sign"></i> {{ number_format($expense->amount, 2) }}
                                </span>
                            </td>
                            <td>{{ $expense->expense_date ? date('d/m/Y', strtotime($expense->expense_date)) : 'N/A' }}</td>
                            <td>{{ $expense->user->name ?? 'N/A' }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('expenses.show', $expense->id) }}" class="btn btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this expense?')" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-money-bill-wave" style="font-size: 40px; color: #6c757d; display: block; margin-bottom: 10px;"></i>
                                No expenses found. <a href="{{ route('expenses.create') }}">Add your first expense</a>
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
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6 class="mb-0"><i class="fas fa-money-bill-wave"></i> Total Expenses</h6>
                <h3><i class="fas fa-rupee-sign"></i> {{ number_format($expenses->sum('amount'), 2) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6 class="mb-0"><i class="fas fa-calendar-alt"></i> This Month</h6>
                <h3><i class="fas fa-rupee-sign"></i> {{ number_format($expenses->where('expense_date', '>=', date('Y-m-01'))->sum('amount'), 2) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h6 class="mb-0"><i class="fas fa-calendar-day"></i> Today</h6>
                <h3><i class="fas fa-rupee-sign"></i> {{ number_format($expenses->where('expense_date', date('Y-m-d'))->sum('amount'), 2) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6 class="mb-0"><i class="fas fa-list"></i> Total Entries</h6>
                <h3>{{ $expenses->count() }}</h3>
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