@extends('layouts.app')

@section('title', 'Checkout - Beli Produk')

@section('content')
<div class="container">
    <h1 class="h4 mb-3">Checkout: {{ $product->model_name }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <p><strong>Harga:</strong> Rp {{ number_format($product->price,0,',','.') }}</p>
                    <p><strong>Stok:</strong> {{ $product->stock }}</p>

                    <form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->product_id }}">

                        <div class="mb-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Metode Pembayaran</label>
                            <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror">
                                <option value="cash" {{ old('payment_method') === 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="transfer" {{ old('payment_method') === 'transfer' ? 'selected' : '' }}>Transfer</option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Unggah Bukti Transfer</label>
                            <input type="file" name="payment_proof" class="form-control @error('payment_proof') is-invalid @enderror">
                            @error('payment_proof')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Bisa file apa saja, termasuk PNG. Tidak ada batasan ukuran.</div>
                        </div>

                        <button class="btn btn-primary">Bayar / Submit Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
