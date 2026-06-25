@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3">Detail Pesanan #{{ $order->order_id }}</h1>
            <p class="text-muted">Status pesanan Anda di sini.</p>
        </div>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <p><strong>Pesanan:</strong></p>
            <ul>
                @foreach($order->items as $item)
                    <li>{{ $item->product?->model_name ?? 'Produk tidak ditemukan' }} x {{ $item->quantity }} (Rp {{ number_format($item->price,0,',','.') }})</li>
                @endforeach
            </ul>
            <p><strong>Total:</strong> Rp {{ number_format($order->total_amount,0,',','.') }}</p>
            <p><strong>Metode Pembayaran:</strong> {{ ucfirst($order->payment_method ?? 'cash') }}</p>
            <p><strong>Status:</strong>
                @if($order->status === 'waiting_verification')
                    <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                @elseif($order->status === 'verified')
                    <span class="badge bg-success">Terverifikasi</span>
                @else
                    <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                @endif
            </p>

            @if($order->payment_method === 'transfer')
                <hr>
                @if($order->payment_proof_path)
                    <p><strong>Bukti Transfer:</strong></p>
                    <a href="{{ asset('storage/' . $order->payment_proof_path) }}" target="_blank">Lihat bukti transfer</a>
                @else
                    <p class="text-danger">Bukti transfer belum diunggah.</p>
                @endif
            @endif

            @if($order->status === 'waiting_verification')
                <div class="alert alert-warning mt-4">Pesanan Anda sedang menunggu verifikasi admin.</div>
            @elseif($order->status === 'verified')
                <div class="alert alert-success mt-4">Pesanan Anda sudah terverifikasi.</div>
            @endif
        </div>
    </div>
</div>
@endsection
