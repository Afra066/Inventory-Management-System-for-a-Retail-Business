<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('supplier')->get();
        return view('products.index', compact('products'));
    }

    public function create(Request $request)
    {
        // Sales Staff cannot create products
        if (!in_array(Auth::user()->role, ['admin', 'accountant'])) {
            abort(403, 'Only Admin and Accountant can create products.');
        }
        
        $suppliers = Supplier::all();
        return view('products.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        if (!in_array(Auth::user()->role, ['admin', 'accountant'])) {
            abort(403, 'Only Admin and Accountant can create products.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'sku' => 'nullable|string|unique:products,sku',
            'supplier_id' => 'nullable|exists:suppliers,id',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'sku' => $request->sku,
            'supplier_id' => $request->supplier_id,
        ]);

        if ($request->supplier_id) {
            return redirect()->route('suppliers.show', $request->supplier_id)
                ->with('success', 'Product "' . $product->name . '" added successfully!');
        }

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully!');
    }

    public function show(Product $product)
    {
        $product->load('supplier');
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        // Sales Staff cannot edit products
        if (!in_array(Auth::user()->role, ['admin', 'accountant'])) {
            abort(403, 'Only Admin and Accountant can edit products.');
        }

        $suppliers = Supplier::all();
        return view('products.edit', compact('product', 'suppliers'));
    }

    public function update(Request $request, Product $product)
    {
        if (!in_array(Auth::user()->role, ['admin', 'accountant'])) {
            abort(403, 'Only Admin and Accountant can update products.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
            'supplier_id' => 'nullable|exists:suppliers,id',
        ]);

        $product->update([
            'name' => $request->name,
            'category' => $request->category,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'sku' => $request->sku,
            'supplier_id' => $request->supplier_id,
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        // Sales Staff cannot delete products
        if (!in_array(Auth::user()->role, ['admin', 'accountant'])) {
            abort(403, 'Only Admin and Accountant can delete products.');
        }

        $product->delete('');

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully!');
    }
}