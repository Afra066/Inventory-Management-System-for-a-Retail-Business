@extends('layouts.app')

@section('title', 'Employees - iPower System')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-users-cog" style="color: #00d2ff;"></i> Employees</h2>
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="fas fa-user-plus"></i> Add Employee
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
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
                        <th style="width: 25%;">Name</th>
                        <th style="width: 25%;">Email</th>
                        <th style="width: 20%;">Role</th>
                        <th style="width: 25%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td><strong>{{ $user->name }}</strong></td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'accountant' ? 'warning' : 'secondary') }}" style="font-size: 14px;">
                                    @if($user->role == 'admin')
                                        <i class="fas fa-crown"></i>
                                    @elseif($user->role == 'accountant')
                                        <i class="fas fa-calculator"></i>
                                    @else
                                        <i class="fas fa-store"></i>
                                    @endif
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($user->id !== Auth::id())
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this employee?')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <i class="fas fa-users" style="font-size: 40px; color: #6c757d; display: block; margin-bottom: 10px;"></i>
                                No employees found.
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