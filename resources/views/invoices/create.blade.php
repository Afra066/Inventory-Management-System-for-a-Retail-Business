@extends('layouts.app')

@section('title', 'Create Invoice - iPower System')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Create New Invoice</h2>
    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('invoices.store') }}" method="POST" id="invoiceForm">
            @csrf

            <!-- Invoice Details -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="customer_id" class="form-label">Customer <span class="text-danger">*</span></label>
                    <select class="form-control @error('customer_id') is-invalid @enderror" 
                            id="customer_id" name="customer_id" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} ({{ $customer->email ?? 'No email' }})
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="payment_status" class="form-label">Payment Status <span class="text-danger">*</span></label>
                    <select class="form-control @error('payment_status') is-invalid @enderror" 
                            id="payment_status" name="payment_status" required>
                        <option value="pending" {{ old('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="partial" {{ old('payment_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    @error('payment_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="due_date" class="form-label">Due Date</label>
                    <input type="date" class="form-control @error('due_date') is-invalid @enderror" 
                           id="due_date" name="due_date" value="{{ old('due_date') }}">
                    @error('due_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <input type="text" class="form-control @error('notes') is-invalid @enderror" 
                           id="notes" name="notes" value="{{ old('notes') }}" placeholder="Any additional notes">
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Invoice Items -->
            <div class="mt-3">
                <h5>Invoice Items</h5>
                <div class="table-responsive">
                    <table class="table table-bordered" id="itemsTable">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 40%;">Item</th>
                                <th style="width: 15%;">Quantity</th>
                                <th style="width: 20%;">Price</th>
                                <th style="width: 20%;">Total</th>
                                <th style="width: 5%;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemsContainer">
                            <tr class="item-row">
                                <td>
                                    <select class="form-control product-select" name="items[0][product_id]" required>
                                        <option value="">Select Product</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                                {{ $product->name }} (Stock: {{ $product->quantity ?? 'N/A' }})
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" class="form-control quantity-input" name="items[0][quantity]" 
                                           placeholder="Qty" min="1" value="1" required>
                                </td>
                                <td>
                                    <input type="number" step="0.01" class="form-control price-input" name="items[0][price]" 
                                           placeholder="Price" min="0" required>
                                </td>
                                <td>
                                    <span class="form-control subtotal-display" style="background: #f8f9fa;">Rs. 0.00</span>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-sm remove-item">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button type="button" id="addItemBtn" class="btn btn-success btn-sm mt-2">
                    <i class="fas fa-plus"></i> Add Item
                </button>
            </div>

            <!-- Totals -->
            <div class="row mt-4">
                <div class="col-md-6 offset-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 50%;">Subtotal</th>
                            <td id="subtotalDisplay" style="text-align: right;">Rs. 0.00</td>
                        </tr>
                        <tr>
                            <th>Discount (%)</th>
                            <td style="text-align: right;">
                                <div class="input-group">
                                    <input type="number" class="form-control text-end" name="discount" 
                                           id="discountInput" value="0" min="0" max="100" step="0.01" style="width: 80px;">
                                    <span class="input-group-text">%</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Discount Amount</th>
                            <td id="discountAmountDisplay" style="text-align: right;">Rs. 0.00</td>
                        </tr>
                        <tr>
                            <th>Tax (%)</th>
                            <td style="text-align: right;">
                                <div class="input-group">
                                    <input type="number" class="form-control text-end" name="tax" 
                                           id="taxInput" value="0" min="0" max="100" step="0.01" style="width: 80px;">
                                    <span class="input-group-text">%</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Tax Amount</th>
                            <td id="taxAmountDisplay" style="text-align: right;">Rs. 0.00</td>
                        </tr>
                        <tr class="table-primary">
                            <th style="font-size: 18px;">TOTAL</th>
                            <td id="totalDisplay" style="text-align: right; font-size: 18px; font-weight: 700;">Rs. 0.00</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Hidden fields -->
            <input type="hidden" name="discount_amount" id="discountAmountHidden" value="0">
            <input type="hidden" name="tax_amount" id="taxAmountHidden" value="0">

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Create Invoice
                </button>
                <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<style>
    .item-row td {
        vertical-align: middle !important;
    }
    .input-group-text {
        background: #1a1a2e;
        color: #fff;
        border: 1px solid #1a1a2e;
    }
    .table-primary td {
        background-color: #1a1a2e !important;
        color: #fff !important;
    }
    .table-primary th {
        background-color: #1a1a2e !important;
        color: #fff !important;
    }
    .form-control:focus {
        border-color: #00d2ff;
        box-shadow: 0 0 0 0.2rem rgba(0, 210, 255, 0.25);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let itemIndex = 1;

    // Add item row
    document.getElementById('addItemBtn').addEventListener('click', function() {
        const container = document.getElementById('itemsContainer');
        const newRow = document.createElement('tr');
        newRow.className = 'item-row';
        newRow.innerHTML = `
            <td>
                <select class="form-control product-select" name="items[${itemIndex}][product_id]" required>
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                            {{ $product->name }} (Stock: {{ $product->quantity ?? 'N/A' }})
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" class="form-control quantity-input" name="items[${itemIndex}][quantity]" 
                       placeholder="Qty" min="1" value="1" required>
            </td>
            <td>
                <input type="number" step="0.01" class="form-control price-input" name="items[${itemIndex}][price]" 
                       placeholder="Price" min="0" required>
            </td>
            <td>
                <span class="form-control subtotal-display" style="background: #f8f9fa;">Rs. 0.00</span>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm remove-item">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        container.appendChild(newRow);
        itemIndex++;
        attachEvents(newRow);
    });

    // Attach events to a row
    function attachEvents(row) {
        const productSelect = row.querySelector('.product-select');
        const priceInput = row.querySelector('.price-input');
        const quantityInput = row.querySelector('.quantity-input');
        const subtotalDisplay = row.querySelector('.subtotal-display');

        productSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption && selectedOption.dataset.price) {
                priceInput.value = selectedOption.dataset.price;
            }
            calculateSubtotal(row);
            calculateTotals();
        });

        priceInput.addEventListener('input', function() {
            calculateSubtotal(row);
            calculateTotals();
        });

        quantityInput.addEventListener('input', function() {
            calculateSubtotal(row);
            calculateTotals();
        });

        // Remove item
        const removeBtn = row.querySelector('.remove-item');
        removeBtn.addEventListener('click', function() {
            const container = document.getElementById('itemsContainer');
            if (container.children.length > 1) {
                row.remove();
                calculateTotals();
            } else {
                alert('You need at least one item!');
            }
        });
    }

    // Calculate subtotal for a row
    function calculateSubtotal(row) {
        const price = parseFloat(row.querySelector('.price-input').value) || 0;
        const quantity = parseInt(row.querySelector('.quantity-input').value) || 0;
        const subtotal = price * quantity;
        row.querySelector('.subtotal-display').textContent = 'Rs. ' + subtotal.toFixed(2);
    }

    // Calculate all totals with percentage
    function calculateTotals() {
        const rows = document.querySelectorAll('.item-row');
        let subtotal = 0;

        rows.forEach(row => {
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            const quantity = parseInt(row.querySelector('.quantity-input').value) || 0;
            subtotal += price * quantity;
        });

        // Get discount percentage and tax percentage
        const discountPercent = parseFloat(document.getElementById('discountInput').value) || 0;
        const taxPercent = parseFloat(document.getElementById('taxInput').value) || 0;

        // Calculate discount amount and tax amount from percentages
        const discountAmount = (subtotal * discountPercent) / 100;
        const taxAmount = (subtotal * taxPercent) / 100;
        const finalTotal = subtotal - discountAmount + taxAmount;

        // Update displays
        document.getElementById('subtotalDisplay').textContent = 'Rs. ' + subtotal.toFixed(2);
        document.getElementById('discountAmountDisplay').textContent = 'Rs. ' + discountAmount.toFixed(2);
        document.getElementById('taxAmountDisplay').textContent = 'Rs. ' + taxAmount.toFixed(2);
        document.getElementById('totalDisplay').textContent = 'Rs. ' + finalTotal.toFixed(2);

        // Update hidden fields
        document.getElementById('discountAmountHidden').value = discountAmount.toFixed(2);
        document.getElementById('taxAmountHidden').value = taxAmount.toFixed(2);
    }

    // Attach events to initial row
    attachEvents(document.querySelector('.item-row'));

    // Discount and tax input events
    document.getElementById('discountInput').addEventListener('input', calculateTotals);
    document.getElementById('taxInput').addEventListener('input', calculateTotals);
});
</script>
@endsection