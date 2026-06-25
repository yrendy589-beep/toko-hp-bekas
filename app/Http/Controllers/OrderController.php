<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class OrderController extends Controller
{
    public function checkout(Product $product)
    {
        return view('orders.checkout', compact('product'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,transfer',
            'payment_proof' => 'required_if:payment_method,transfer|file',
        ]);

        $user = Auth::user();
        $customer = Customer::firstOrCreate(
            ['email' => $user->email],
            ['name' => $user->name, 'phone' => null, 'address' => null]
        );

        $product = Product::findOrFail($request->product_id);
        $quantity = (int) $request->quantity;
        $total = $product->price * $quantity;

        $orderData = [
            'customer_id' => $customer->customer_id,
            'order_date' => now()->toDateString(),
            'total_amount' => $total,
            'status' => 'waiting_verification',
        ];

        if (Schema::hasColumn('orders', 'payment_method')) {
            $orderData['payment_method'] = $request->payment_method;
        }

        if (Schema::hasColumn('orders', 'payment_proof_path')) {
            $orderData['payment_proof_path'] = null;
        }

        $order = Order::create($orderData);

        OrderItem::create([
            'order_id' => $order->order_id,
            'product_id' => $product->product_id,
            'quantity' => $quantity,
            'price' => $product->price,
        ]);

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payments', 'public');
            if (Schema::hasColumn('orders', 'payment_proof_path')) {
                $order->update(['payment_proof_path' => $path]);
            }
        }

        return redirect()->route('orders.thankyou', $order)->with('success', 'Order berhasil dibuat.');
    }

    public function thankyou(Order $order)
    {
        return view('orders.thankyou', compact('order'));
    }

    public function customerIndex()
    {
        $user = Auth::user();
        $customer = Customer::where('email', $user->email)->first();

        $orders = Order::with('items.product')
            ->when($customer, function ($query, $customer) {
                $query->where('customer_id', $customer->customer_id);
            })
            ->latest('order_date')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $user = Auth::user();
        $customer = Customer::where('email', $user->email)->first();

        if (!$customer || $order->customer_id !== $customer->customer_id) {
            abort(403);
        }

        $order->load('items.product');
        return view('orders.show', compact('order'));
    }

    public function uploadProof(Request $request, Order $order)
    {
        $user = Auth::user();
        $customer = Customer::where('email', $user->email)->first();

        if (! $customer || $order->customer_id !== $customer->customer_id) {
            abort(403);
        }

        $request->validate([
            'payment_proof' => 'required|file',
        ]);

        $path = $request->file('payment_proof')->store('payments', 'public');

        $update = ['status' => 'paid'];
        if (Schema::hasColumn('orders', 'payment_proof_path')) {
            $update['payment_proof_path'] = $path;
        }

        $order->update($update);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah.');
    }

    // Admin: list orders
    public function adminIndex()
    {
        $user = Auth::user();
        if (! $user || $user->role !== 'admin') {
            abort(403);
        }

        $orders = Order::with('customer', 'items.product')
            ->latest('order_date')
            ->paginate(20);

        return view('admin.orders', compact('orders'));
    }

    public function verify(Order $order)
    {
        $user = Auth::user();
        if (! $user || $user->role !== 'admin') {
            abort(403);
        }

        $order->update(['status' => 'verified']);

        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil diverifikasi.');
    }

    public function destroy(Order $order)
    {
        $user = Auth::user();
        if (! $user || $user->role !== 'admin') {
            abort(403);
        }

        OrderItem::where('order_id', $order->order_id)->delete();
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil dihapus.');
    }
}
