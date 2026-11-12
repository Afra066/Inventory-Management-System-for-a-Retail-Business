<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    // Display a listing of customers
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    // Show form to create new customer
    public function create()
    {
        return view('customers.create');
    }

    // Store newly created customer
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully!');
    }

    // Display specific customer
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    // Show form to edit customer
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    // Update customer
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully!');
    }

    // Delete customer
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully!');
    }
}