@extends('layouts.app')

@section('title', 'Terima Kasih')

@section('content')
<div class="container">
    <h1 class="h4 mb-3">Terima Kasih — Pesanan Diterima</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <p>Order ID: {{ $order->id }}</p>
    <p>Produk: {{ $order->product->model_name }}</p>
    <p>Jumlah: {{ $order->quantity }}</p>
    <p>Total: Rp {{ number_format($order->total_price,0,',','.') }}</p>

    @if(!$order->payment_proof_path)
        <hr>
        <h5>Unggah Bukti Pembayaran</h5>
        <form action="{{ route('orders.upload-proof', $order) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <input type="file" name="payment_proof" class="form-control" required>
            </div>
            <button class="btn btn-primary">Unggah</button>
        </form>
    @else
        <p>Bukti pembayaran telah diunggah.</p>
    @endif
</div>
@endsection
