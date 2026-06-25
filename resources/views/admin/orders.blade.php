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
                    <th>User</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Bukti</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user?->name ?? 'Guest' }}</td>
                        <td>{{ $order->product?->model_name }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>Rp {{ number_format($order->total_price,0,',','.') }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>
                            @if($order->payment_proof_path)
                                <a href="{{ asset('storage/' . $order->payment_proof_path) }}" target="_blank">Lihat</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $orders->links() }}</div>
</div>
@endsection
