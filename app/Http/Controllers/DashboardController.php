<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;

        // Check role and return the correct dashboard view
        if ($role === 'admin') {
            return view('dashboards.admin');
        } elseif ($role === 'accountant') {
            return view('dashboards.accountant');
        } elseif ($role === 'sales_staff') {
            return view('dashboards.sales_staff');
        }

        // Default fallback
        return view('dashboard');
    }
}