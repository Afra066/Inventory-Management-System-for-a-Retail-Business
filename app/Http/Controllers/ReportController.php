<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Expense;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        if (!in_array(Auth::user()->role, ['admin', 'accountant'])) {
            abort(403, 'Unauthorized access.');
        }

        $today = date('Y-m-d');
        $month = date('m');
        $year = date('Y');

        // Today's sales - using raw SQL
        $todaySales = DB::select("SELECT SUM(total_amount) as total FROM invoices WHERE DATE(created_at) = ?", [$today]);
        $todaySales = $todaySales[0]->total ?? 0;
        
        $todayCount = DB::select("SELECT COUNT(*) as count FROM invoices WHERE DATE(created_at) = ?", [$today]);
        $todayCount = $todayCount[0]->count ?? 0;

        // This month sales
        $monthlySales = DB::select("SELECT SUM(total_amount) as total FROM invoices WHERE MONTH(created_at) = ? AND YEAR(created_at) = ?", [$month, $year]);
        $monthlySales = $monthlySales[0]->total ?? 0;
        
        $monthlyCount = DB::select("SELECT COUNT(*) as count FROM invoices WHERE MONTH(created_at) = ? AND YEAR(created_at) = ?", [$month, $year]);
        $monthlyCount = $monthlyCount[0]->count ?? 0;

        // Total revenue
        $totalRevenue = DB::select("SELECT SUM(total_amount) as total FROM invoices");
        $totalRevenue = $totalRevenue[0]->total ?? 0;
        
        $totalInvoices = DB::select("SELECT COUNT(*) as count FROM invoices");
        $totalInvoices = $totalInvoices[0]->count ?? 0;

        // Total expenses
        $totalExpenses = DB::select("SELECT SUM(amount) as total FROM expenses");
        $totalExpenses = $totalExpenses[0]->total ?? 0;
        
        $totalExpenseCount = DB::select("SELECT COUNT(*) as count FROM expenses");
        $totalExpenseCount = $totalExpenseCount[0]->count ?? 0;

        // Net profit
        $netProfit = $totalRevenue - $totalExpenses;

        return view('reports.index', compact(
            'todaySales', 'todayCount',
            'monthlySales', 'monthlyCount',
            'totalRevenue', 'totalInvoices',
            'totalExpenses', 'totalExpenseCount',
            'netProfit'
        ));
    }

    public function dailySales(Request $request)
    {
        if (!in_array(Auth::user()->role, ['admin', 'accountant'])) {
            abort(403, 'Unauthorized access.');
        }

        $date = $request->date ?? date('Y-m-d');
        
        $invoices = DB::select("
            SELECT i.*, c.name as customer_name, u.name as user_name 
            FROM invoices i
            LEFT JOIN customers c ON i.customer_id = c.id
            LEFT JOIN users u ON i.user_id = u.id
            WHERE DATE(i.created_at) = ?
            ORDER BY i.created_at DESC
        ", [$date]);

        $totalSales = DB::select("SELECT SUM(total_amount) as total FROM invoices WHERE DATE(created_at) = ?", [$date]);
        $totalSales = $totalSales[0]->total ?? 0;
        
        $totalCount = DB::select("SELECT COUNT(*) as count FROM invoices WHERE DATE(created_at) = ?", [$date]);
        $totalCount = $totalCount[0]->count ?? 0;

        return view('reports.daily', compact('invoices', 'totalSales', 'totalCount', 'date'));
    }

    public function monthlySales(Request $request)
    {
        if (!in_array(Auth::user()->role, ['admin', 'accountant'])) {
            abort(403, 'Unauthorized access.');
        }

        $month = $request->month ?? date('m');
        $year = $request->year ?? date('Y');
        
        $invoices = DB::select("
            SELECT i.*, c.name as customer_name, u.name as user_name 
            FROM invoices i
            LEFT JOIN customers c ON i.customer_id = c.id
            LEFT JOIN users u ON i.user_id = u.id
            WHERE MONTH(i.created_at) = ? AND YEAR(i.created_at) = ?
            ORDER BY i.created_at DESC
        ", [$month, $year]);

        $totalSales = DB::select("SELECT SUM(total_amount) as total FROM invoices WHERE MONTH(created_at) = ? AND YEAR(created_at) = ?", [$month, $year]);
        $totalSales = $totalSales[0]->total ?? 0;
        
        $totalCount = DB::select("SELECT COUNT(*) as count FROM invoices WHERE MONTH(created_at) = ? AND YEAR(created_at) = ?", [$month, $year]);
        $totalCount = $totalCount[0]->count ?? 0;

        // Daily breakdown for chart
        $dailyData = [];
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
            $result = DB::select("SELECT SUM(total_amount) as total FROM invoices WHERE DATE(created_at) = ?", [$date]);
            $dailyData[$i] = $result[0]->total ?? 0;
        }

        $monthName = date('F Y', strtotime($year . '-' . $month . '-01'));

        return view('reports.monthly', compact(
            'invoices', 'totalSales', 'totalCount', 
            'month', 'year', 'dailyData', 'monthName'
        ));
    }

    public function profitLoss(Request $request)
    {
        if (!in_array(Auth::user()->role, ['admin', 'accountant'])) {
            abort(403, 'Unauthorized access.');
        }

        $year = $request->year ?? date('Y');
        $month = $request->month ?? null;

        $revenueQuery = "SELECT SUM(total_amount) as total FROM invoices WHERE YEAR(created_at) = ?";
        $expenseQuery = "SELECT SUM(amount) as total FROM expenses WHERE YEAR(created_at) = ?";
        $params = [$year];

        if ($month) {
            $revenueQuery .= " AND MONTH(created_at) = ?";
            $expenseQuery .= " AND MONTH(created_at) = ?";
            $params[] = $month;
        }

        $totalRevenue = DB::select($revenueQuery, $params)[0]->total ?? 0;
        $totalExpenses = DB::select($expenseQuery, $params)[0]->total ?? 0;
        
        $netProfit = $totalRevenue - $totalExpenses;
        
        $invoiceCount = DB::select("SELECT COUNT(*) as count FROM invoices WHERE YEAR(created_at) = ?" . ($month ? " AND MONTH(created_at) = ?" : ""), $params)[0]->count ?? 0;
        $expenseCount = DB::select("SELECT COUNT(*) as count FROM expenses WHERE YEAR(created_at) = ?" . ($month ? " AND MONTH(created_at) = ?" : ""), $params)[0]->count ?? 0;

        // Monthly breakdown for chart
        $monthlyRevenue = [];
        $monthlyExpensesData = [];
        for ($i = 1; $i <= 12; $i++) {
            $revResult = DB::select("SELECT SUM(total_amount) as total FROM invoices WHERE YEAR(created_at) = ? AND MONTH(created_at) = ?", [$year, $i]);
            $monthlyRevenue[$i] = $revResult[0]->total ?? 0;
            
            $expResult = DB::select("SELECT SUM(amount) as total FROM expenses WHERE YEAR(created_at) = ? AND MONTH(created_at) = ?", [$year, $i]);
            $monthlyExpensesData[$i] = $expResult[0]->total ?? 0;
        }

        $yearName = $year;
        $monthName = $month ? date('F', strtotime($year . '-' . $month . '-01')) : 'Full Year';

        return view('reports.profit_loss', compact(
            'totalRevenue', 'totalExpenses', 'netProfit',
            'invoiceCount', 'expenseCount',
            'year', 'month', 'yearName', 'monthName',
            'monthlyRevenue', 'monthlyExpensesData'
        ));
    }

    public function expenseReport(Request $request)
    {
        if (!in_array(Auth::user()->role, ['admin', 'accountant'])) {
            abort(403, 'Unauthorized access.');
        }

        $startDate = $request->start_date ?? date('Y-m-01');
        $endDate = $request->end_date ?? date('Y-m-d');

        $expenses = DB::select("
            SELECT e.*, u.name as user_name 
            FROM expenses e
            LEFT JOIN users u ON e.user_id = u.id
            WHERE DATE(e.created_at) >= ? AND DATE(e.created_at) <= ?
            ORDER BY e.created_at DESC
        ", [$startDate, $endDate]);

        $totalExpenses = DB::select("SELECT SUM(amount) as total FROM expenses WHERE DATE(created_at) >= ? AND DATE(created_at) <= ?", [$startDate, $endDate]);
        $totalExpenses = $totalExpenses[0]->total ?? 0;
        
        $totalCount = DB::select("SELECT COUNT(*) as count FROM expenses WHERE DATE(created_at) >= ? AND DATE(created_at) <= ?", [$startDate, $endDate]);
        $totalCount = $totalCount[0]->count ?? 0;

        $categoryData = DB::select("
            SELECT category, SUM(amount) as total 
            FROM expenses 
            WHERE DATE(created_at) >= ? AND DATE(created_at) <= ?
            GROUP BY category
        ", [$startDate, $endDate]);

        return view('reports.expenses', compact(
            'expenses', 'totalExpenses', 'totalCount',
            'startDate', 'endDate', 'categoryData'
        ));
    }

    public function stockReport()
    {
        if (!in_array(Auth::user()->role, ['admin', 'accountant'])) {
            abort(403, 'Unauthorized access.');
        }

        $products = DB::select("
            SELECT p.*, s.name as supplier_name 
            FROM products p
            LEFT JOIN suppliers s ON p.supplier_id = s.id
            ORDER BY p.quantity ASC
        ");

        $totalProducts = count($products);
        $lowStock = 0;
        $outOfStock = 0;
        
        foreach ($products as $product) {
            if (isset($product->quantity)) {
                if ($product->quantity <= 0) {
                    $outOfStock++;
                } elseif ($product->quantity <= 5) {
                    $lowStock++;
                }
            }
        }

        return view('reports.stock', compact('products', 'totalProducts', 'lowStock', 'outOfStock'));
    }
}