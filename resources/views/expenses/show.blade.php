@extends('layouts.app')

@section('title', 'Expense Details - iPower System')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-receipt" style="color: #00d2ff;"></i> Expense Details</h2>
    <div>
        <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0"><i class="fas fa-info-circle"></i> Expense Information</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 30%;"><i class="fas fa-hashtag"></i> Expense ID</th>
                        <td>{{ $expense->id }}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-pencil-alt"></i> Description</th>
                        <td><strong>{{ $expense->description }}</strong></td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-tags"></i> Category</th>
                        <td>
                            @if($expense->category == 'Utilities')
                                <span class="badge bg-warning"><i class="fas fa-bolt"></i> {{ $expense->category }}</span>
                            @elseif($expense->category == 'Rent')
                                <span class="badge bg-primary"><i class="fas fa-building"></i> {{ $expense->category }}</span>
                            @elseif($expense->category == 'Salaries')
                                <span class="badge bg-info"><i class="fas fa-users"></i> {{ $expense->category }}</span>
                            @else
                                <span class="badge bg-secondary">{{ $expense->category ?? 'N/A' }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-dollar-sign"></i> Amount</th>
                        <td><span class="badge bg-danger" style="font-size: 18px;"><i class="fas fa-rupee-sign"></i> {{ number_format($expense->amount, 2) }}</span></td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-calendar-alt"></i> Expense Date</th>
                        <td>{{ $expense->expense_date ? date('d/m/Y', strtotime($expense->expense_date)) : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-user"></i> Added By</th>
                        <td>{{ $expense->user->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-sticky-note"></i> Notes</th>
                        <td>{{ $expense->notes ?? 'No notes' }}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-clock"></i> Created At</th>
                        <td>{{ $expense->created_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-clock"></i> Last Updated</th>
                        <td>{{ $expense->updated_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0"><i class="fas fa-chart-pie"></i> Quick Summary</h6>
            </div>
            <div class="card-body">
                @php
                    $totalExpenses = \App\Models\Expense::sum('amount');
                    $thisMonth = \App\Models\Expense::where('expense_date', '>=', date('Y-m-01'))->sum('amount');
                    $today = \App\Models\Expense::where('expense_date', date('Y-m-d'))->sum('amount');
                @endphp
                <div class="row text-center">
                    <div class="col-6">
                        <h6><i class="fas fa-money-bill-wave"></i> Total Expenses</h6>
                        <h4 class="text-danger"><i class="fas fa-rupee-sign"></i> {{ number_format($totalExpenses, 2) }}</h4>
                    </div>
                    <div class="col-6">
                        <h6><i class="fas fa-calendar-alt"></i> This Month</h6>
                        <h4 class="text-warning"><i class="fas fa-rupee-sign"></i> {{ number_format($thisMonth, 2) }}</h4>
                    </div>
                    <div class="col-12 mt-3">
                        <h6><i class="fas fa-calendar-day"></i> Today's Expenses</h6>
                        <h4 class="text-info"><i class="fas fa-rupee-sign"></i> {{ number_format($today, 2) }}</h4>
                    </div>
                </div>
                <hr>
                <div class="d-grid gap-2">
                    <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit This Expense
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection