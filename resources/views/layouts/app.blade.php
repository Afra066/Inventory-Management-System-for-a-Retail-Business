<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'iPower System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
        }

        /* Sidebar */
        .sidebar {
            min-height: 100vh;
            background: #1a1a2e;
            padding: 0;
            position: sticky;
            top: 0;
        }

        .sidebar .brand {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar .brand h5 {
            color: #fff;
            margin: 0;
            font-size: 20px;
        }

        .sidebar .brand span {
            color: #00d2ff;
        }

        .sidebar .brand small {
            color: rgba(255,255,255,0.3);
            font-size: 10px;
            display: block;
            margin-top: 2px;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 4px 10px;
            transition: all 0.3s;
            font-size: 14px;
            text-decoration: none;
            display: block;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .sidebar .nav-link .badge {
            float: right;
            margin-top: 2px;
        }

        /* Main Content */
        .main-content {
            padding: 20px;
            min-height: 100vh;
        }

        /* Stat Cards */
        .stat-card {
            border-radius: 12px;
            padding: 20px;
            color: white;
            transition: transform 0.2s;
            border: none;
            cursor: default;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card .stat-icon {
            font-size: 30px;
            opacity: 0.4;
        }

        .stat-card .stat-number {
            font-size: 28px;
            font-weight: 700;
        }

        .stat-card .stat-label {
            font-size: 13px;
            opacity: 0.8;
        }

        /* Card Styles */
        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #f0f0f0;
            padding: 15px 20px;
            border-radius: 12px 12px 0 0 !important;
        }

        /* Table Styles */
        .table th {
            font-weight: 600;
            font-size: 12px;
            color: #6c757d;
            border-top: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table td {
            font-size: 14px;
            vertical-align: middle;
        }

        /* Alert Styles */
        .alert {
            border-radius: 12px;
            border: none;
        }

        /* Button Styles */
        .btn-sm {
            padding: 6px 16px;
            font-size: 13px;
            border-radius: 8px;
        }

        /* Gradient Backgrounds */
        .bg-gradient-blue { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; }
        .bg-gradient-green { background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%); color: #fff; }
        .bg-gradient-orange { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: #fff; }
        .bg-gradient-cyan { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: #fff; }
        .bg-gradient-purple { background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%); color: #fff; }
        .bg-gradient-red { background: linear-gradient(135deg, #f43b47 0%, #453a94 100%); color: #fff; }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
                position: relative;
            }
            .sidebar .nav-link {
                padding: 8px 15px;
                font-size: 13px;
            }
            .main-content {
                padding: 15px;
            }
            .stat-card .stat-number {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <div class="brand">
                    <h5><i class="fas fa-mobile-alt" style="color: #00d2ff;"></i> iPower <span>System</span></h5>
                    <small>v1.0.0</small>
                </div>
                <nav class="nav flex-column mt-3">
                    @auth
                        <!-- Dashboard - All Users -->
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fas fa-th-large"></i> Dashboard
                        </a>

                        <!-- Employees - Admin only -->
                        @if(Auth::user()->role === 'admin')
                            <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                <i class="fas fa-users-cog"></i> Employees
                                @php $userCount = \App\Models\User::count(); @endphp
                                @if($userCount > 0)
                                    <span class="badge bg-secondary">{{ $userCount }}</span>
                                @endif
                            </a>
                        @endif

                        <!-- Products - All Users (Sales Staff can view only) -->
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                            <i class="fas fa-box"></i> Products
                            @php $productCount = \App\Models\Product::count(); @endphp
                            @if($productCount > 0)
                                <span class="badge bg-secondary">{{ $productCount }}</span>
                            @endif
                        </a>

                        <!-- Customers - All Users -->
                        <a class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}" href="{{ route('customers.index') }}">
                            <i class="fas fa-users"></i> Customers
                            @php $customerCount = \App\Models\Customer::count(); @endphp
                            @if($customerCount > 0)
                                <span class="badge bg-secondary">{{ $customerCount }}</span>
                            @endif
                        </a>

                        <!-- Suppliers - Admin + Accountant only -->
                        @if(in_array(Auth::user()->role, ['admin', 'accountant']))
                            <a class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                                <i class="fas fa-truck"></i> Suppliers
                                @php $supplierCount = \App\Models\Supplier::count(); @endphp
                                @if($supplierCount > 0)
                                    <span class="badge bg-secondary">{{ $supplierCount }}</span>
                                @endif
                            </a>
                        @endif

                        <!-- Expenses - Admin + Accountant only -->
                        @if(in_array(Auth::user()->role, ['admin', 'accountant']))
                            <a class="nav-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}" href="{{ route('expenses.index') }}">
                                <i class="fas fa-money-bill-wave"></i> Expenses
                                @php $expenseCount = \App\Models\Expense::count(); @endphp
                                @if($expenseCount > 0)
                                    <span class="badge bg-secondary">{{ $expenseCount }}</span>
                                @endif
                            </a>
                        @endif

                        <!-- Invoices - Admin + Accountant only -->
                        @if(in_array(Auth::user()->role, ['admin', 'accountant']))
                            <a class="nav-link {{ request()->routeIs('invoices.*') ? 'active' : '' }}" href="{{ route('invoices.index') }}">
                                <i class="fas fa-file-invoice"></i> Invoices
                                @php $invoiceCount = \App\Models\Invoice::count(); @endphp
                                @if($invoiceCount > 0)
                                    <span class="badge bg-secondary">{{ $invoiceCount }}</span>
                                @endif
                            </a>
                        @endif

                        <!-- Reports - Admin + Accountant only -->
                        @if(in_array(Auth::user()->role, ['admin', 'accountant']))
                            <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                                <i class="fas fa-chart-bar"></i> Reports
                            </a>
                        @endif

                        <hr style="border-color: rgba(255,255,255,0.1); margin: 10px;">

                        <!-- Logout Button -->
                                <div style="padding: 0 15px; margin-top: 10px;">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger w-100" style="border-radius: 8px;">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </button>
                                    </form>
                                </div>

                        <!-- User Info -->
                        <div style="padding: 15px; text-align: center; color: rgba(255,255,255,0.3); font-size: 11px; margin-top: 10px;">
                            {{ Auth::user()->name }}<br>
                            <span class="badge bg-{{ Auth::user()->role == 'admin' ? 'danger' : (Auth::user()->role == 'accountant' ? 'warning' : 'secondary') }}">
                                {{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}
                            </span>
                        </div>
                    @endauth
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 main-content">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>