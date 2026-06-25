@extends('layouts.app')

@section('title', 'Admin - Pesanan')

@section('content')
<div class="container">
    <h1 class="h4 mb-3">Daftar Pesanan</h1>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pelanggan</th>
                    <th>Produk</th>
                    <th>Total Qty</th>
                    <th>Metode</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Bukti</th>
                    <th>Aksi</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->order_id }}</td>
                        <td>{{ $order->customer?->name ?? 'Unknown' }}</td>
                        <td>
                            @foreach($order->items as $item)
                                <div>{{ $item->product?->model_name ?? 'Produk tidak ditemukan' }} x {{ $item->quantity }}</div>
                            @endforeach
                        </td>
                        <td>{{ $order->items->sum('quantity') }}</td>
                        <td>{{ ucfirst($order->payment_method ?? 'cash') }}</td>
                        <td>Rp {{ number_format($order->total_amount,0,',','.') }}</td>
                        <td>
                            @if($order->status === 'waiting_verification')
                                <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                            @elseif($order->status === 'verified')
                                <span class="badge bg-success">Terverifikasi</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                            @endif
                        </td>
                        <td>
                            @if($order->payment_proof_path)
                                <a href="{{ asset('storage/' . $order->payment_proof_path) }}" target="_blank">Lihat</a>
                            @elseif($order->payment_method === 'transfer')
                                Belum ada bukti
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                @if($order->status !== 'verified')
                                    <form action="{{ route('admin.orders.verify', $order) }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Verifikasi</button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="m-0" onsubmit="return confirm('Hapus order ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </div>
                        </td>
                        <td>{{ optional($order->order_date)->format('Y-m-d') ?? $order->order_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $orders->links() }}</div>
</div>
@endsection
