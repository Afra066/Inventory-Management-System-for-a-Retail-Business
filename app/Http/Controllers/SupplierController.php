<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    // Display a listing of suppliers
    public function index()
    {
        $suppliers = Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }

    // Show form to create new supplier
    public function create()
    {
        return view('suppliers.create');
    }

    // Store newly created supplier
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:suppliers,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'payment_due' => 'nullable|numeric|min:0',
        ]);

        // Create supplier
        $supplier = Supplier::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'payment_due' => $request->payment_due ?? 0,
        ]);

        // Add products for this supplier
        if ($request->has('products')) {
            foreach ($request->products as $productData) {
                if (!empty($productData['name'])) {
                    Product::create([
                        'name' => $productData['name'],
                        'category' => $productData['category'] ?? null,
                        'quantity' => $productData['quantity'] ?? 0,
                        'price' => $productData['price'] ?? 0,
                        'sku' => null,
                        'supplier_id' => $supplier->id,
                    ]);
                }
            }
        }

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier created successfully with products!');
    }

    // Display specific supplier
    public function show(Supplier $supplier)
    {
        $supplier->load('products');
        return view('suppliers.show', compact('supplier'));
    }

    // Show form to edit supplier
    public function edit(Supplier $supplier)
    {
        $supplier->load('products');
        return view('suppliers.edit', compact('supplier'));
    }

    // Update supplier
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:suppliers,email,' . $supplier->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'payment_due' => 'nullable|numeric|min:0',
        ]);

        $supplier->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'payment_due' => $request->payment_due ?? 0,
        ]);

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier updated successfully!');
    }

    // Delete supplier
    public function destroy(Supplier $supplier)
    {
        // Delete associated products first
        $supplier->products()->delete();
        $supplier->delete('');
        
        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier deleted successfully!');
    }
}