@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3">Pesanan Saya</h1>
            <p class="text-muted">Lihat status pesanan yang sudah Anda buat.</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali ke Produk</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($orders->isEmpty())
        <div class="alert alert-info">Belum ada pesanan.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->order_id }}</td>
                            <td>
                                @foreach($order->items as $item)
                                    <div>{{ $item->product?->model_name ?? 'Produk tidak ditemukan' }} x {{ $item->quantity }}</div>
                                @endforeach
                            </td>
                            <td>{{ $order->items->sum('quantity') }}</td>
                            <td>{{ ucfirst($order->payment_method ?? 'cash') }}</td>
                            <td>
                                @if($order->status === 'waiting_verification')
                                    <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                                @elseif($order->status === 'verified')
                                    <span class="badge bg-success">Terverifikasi</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                            <td>Rp {{ number_format($order->total_amount,0,',','.') }}</td>
                            <td>
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-primary">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
