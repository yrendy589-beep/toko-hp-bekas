<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function checkout(Product $product)
    {
        return view('orders.checkout', compact('product'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = (int) $request->quantity;
        $total = $product->price * $quantity;

        $order = Order::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'quantity' => $quantity,
            'total_price' => $total,
            'status' => $request->hasFile('payment_proof') ? 'paid' : 'pending',
        ]);

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payments', 'public');
            $order->update(['payment_proof_path' => $path]);
        }

        return redirect()->route('orders.thankyou', $order)->with('success', 'Order berhasil dibuat.');
    }

    public function thankyou(Order $order)
    {
        return view('orders.thankyou', compact('order'));
    }

    public function uploadProof(Request $request, Order $order)
    {
        if (Auth::id() !== $order->user_id) {
            abort(403);
        }

        $request->validate([
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $path = $request->file('payment_proof')->store('payments', 'public');
        $order->update(['payment_proof_path' => $path, 'status' => 'paid']);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah.');
    }

    // Admin: list orders
    public function adminIndex()
    {
        $user = Auth::user();
        if (! $user || $user->role !== 'admin') {
            abort(403);
        }

        $orders = Order::with('product', 'user')->latest()->paginate(20);
        return view('admin.orders', compact('orders'));
    }
}
