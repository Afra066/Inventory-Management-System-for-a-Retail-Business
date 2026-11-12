<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with('user')->orderBy('created_at', 'desc')->get();
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:100',
            'expense_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        Expense::create([
            'description' => $request->description,
            'amount' => $request->amount,
            'category' => $request->category,
            'expense_date' => $request->expense_date ?? now(),
            'user_id' => Auth::id(),
            'notes' => $request->notes,
        ]);

        return redirect()->route('expenses.index')
            ->with('success', 'Expense created successfully!');
    }

    public function show(Expense $expense)
    {
        return view('expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        return view('expenses.edit', compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:100',
            'expense_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $expense->update([
            'description' => $request->description,
            'amount' => $request->amount,
            'category' => $request->category,
            'expense_date' => $request->expense_date ?? $expense->expense_date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('expenses.index')
            ->with('success', 'Expense updated successfully!');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete('');
        return redirect()->route('expenses.index')
            ->with('success', 'Expense deleted successfully!');
    }
}