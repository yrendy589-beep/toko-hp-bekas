@extends('layouts.app')

@section('title', 'Terima Kasih')

@section('content')
<div class="container">
    <h1 class="h4 mb-3">Terima Kasih — Pesanan Diterima</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <p>Order ID: {{ $order->order_id }}</p>
    <p>Pesanan:</p>
    <ul>
        @foreach($order->items as $item)
            <li>{{ $item->product?->model_name ?? 'Produk tidak ditemukan' }} x {{ $item->quantity }} - Rp {{ number_format($item->price,0,',','.') }}</li>
        @endforeach
    </ul>
    <p>Metode Pembayaran: {{ ucfirst($order->payment_method ?? 'cash') }}</p>
    <p>Status: {{ $order->status === 'waiting_verification' ? 'Menunggu Verifikasi' : ucfirst($order->status) }}</p>
    <p>Total: Rp {{ number_format($order->total_amount,0,',','.') }}</p>

    @if($order->payment_method === 'transfer')
        <hr>
        @if($order->payment_proof_path)
            <p>Bukti pembayaran telah diunggah.</p>
            <p><a href="{{ asset('storage/' . $order->payment_proof_path) }}" target="_blank">Lihat bukti transfer</a></p>
        @else
            <p class="text-danger">Bukti transfer belum diunggah. Silakan unggah bukti pembayaran Anda.</p>
            <form action="{{ route('orders.upload-proof', $order) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <input type="file" name="payment_proof" class="form-control" required>
                </div>
                <button class="btn btn-primary">Unggah Bukti Transfer</button>
            </form>
        @endif
    @else
        <p>Silakan lakukan pembayaran tunai saat pengambilan barang. Order ini akan diverifikasi oleh admin.</p>
    @endif
</div>
@endsection
