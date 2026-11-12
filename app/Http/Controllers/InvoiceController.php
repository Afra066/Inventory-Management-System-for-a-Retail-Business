<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Product;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    // Display a listing of invoices
    public function index()
    {
        $user = Auth::user();
        
        // Sales Staff can only see their own invoices
        if ($user->role === 'sales_staff') {
            $invoices = Invoice::with(['customer', 'user'])
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        } else {
            // Admin and Accountant can see all invoices
            $invoices = Invoice::with(['customer', 'user'])->latest()->get();
        }
        
        return view('invoices.index', compact('invoices'));
    }

    // Show form to create new invoice
    public function create()
    {
        // Sales Staff CANNOT create invoices
        if (Auth::user()->role === 'sales_staff') {
            abort(403, 'Unauthorized: Sales Staff cannot create invoices.');
        }
        
        $customers = Customer::all();
        
        try {
            $products = Product::where('quantity', '>', 0)->get();
        } catch (\Exception $e) {
            $products = Product::all();
        }
        
        return view('invoices.create', compact('customers', 'products'));
    }

    // Store newly created invoice
    public function store(Request $request)
    {
        // Sales Staff cannot create invoices
        if (Auth::user()->role === 'sales_staff') {
            abort(403, 'Unauthorized: Sales Staff cannot create invoices.');
        }

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'payment_status' => 'required|in:paid,pending,partial',
            'due_date' => 'nullable|date|after_or_equal:today',
        ]);

        // Calculate subtotal
        $subtotal = 0;
        foreach ($request->items as $item) {
            $subtotal += $item['quantity'] * $item['price'];
        }

        // Get discount percentage and tax percentage
        $discountPercent = $request->discount ?? 0;
        $taxPercent = $request->tax ?? 0;

        // Calculate discount amount and tax amount from percentages
        $discountAmount = ($subtotal * $discountPercent) / 100;
        $taxAmount = ($subtotal * $taxPercent) / 100;
        $finalTotal = $subtotal - $discountAmount + $taxAmount;

        // Generate invoice number
        $invoiceNumber = 'INV-' . date('Ymd') . '-' . str_pad(Invoice::count() + 1, 4, '0', STR_PAD_LEFT);

        // Create invoice
        $invoice = Invoice::create([
            'invoice_number' => $invoiceNumber,
            'customer_id' => $request->customer_id,
            'user_id' => Auth::id(),
            'total_amount' => $finalTotal,
            'discount' => $discountAmount,
            'tax' => $taxAmount,
            'payment_status' => $request->payment_status,
            'due_date' => $request->due_date,
            'notes' => $request->notes,
        ]);

        // Create invoice items and update stock
        foreach ($request->items as $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['quantity'] * $item['price'],
            ]);

            // Update stock
            try {
                $product = Product::find($item['product_id']);
                if ($product && isset($product->quantity)) {
                    $product->quantity -= $item['quantity'];
                    $product->save();
                }
            } catch (\Exception $e) {
                // Skip stock update if quantity column doesn't exist
            }
        }

        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Invoice created successfully! Invoice #' . $invoiceNumber);
    }

    // Display specific invoice
    public function show(Invoice $invoice)
    {
        // Sales Staff can only view their own invoices
        if (Auth::user()->role === 'sales_staff' && $invoice->user_id !== Auth::id()) {
            abort(403, 'You can only view your own invoices.');
        }
        
        $invoice->load(['customer', 'user', 'items.product']);
        return view('invoices.show', compact('invoice'));
    }

    // Show form to edit invoice (only payment status)
    public function edit(Invoice $invoice)
    {
        // Sales Staff can only edit their own invoices
        if (Auth::user()->role === 'sales_staff' && $invoice->user_id !== Auth::id()) {
            abort(403, 'You can only edit your own invoices.');
        }
        
        return view('invoices.edit', compact('invoice'));
    }

    // Update invoice (only payment status)
    public function update(Request $request, Invoice $invoice)
    {
        // Sales Staff can only update their own invoices
        if (Auth::user()->role === 'sales_staff' && $invoice->user_id !== Auth::id()) {
            abort(403, 'You can only update your own invoices.');
        }

        $request->validate([
            'payment_status' => 'required|in:paid,pending,partial',
        ]);

        $invoice->update([
            'payment_status' => $request->payment_status,
        ]);

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice payment status updated successfully!');
    }

    // Delete invoice
    public function destroy(Invoice $invoice)
    {
        // Sales Staff can only delete their own invoices
        if (Auth::user()->role === 'sales_staff' && $invoice->user_id !== Auth::id()) {
            abort(403, 'You can only delete your own invoices.');
        }

        // Delete invoice items first
        $invoice->items()->delete();
        $invoice->delete('');

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice deleted successfully!');
    }
}