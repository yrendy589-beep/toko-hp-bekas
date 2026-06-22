@extends('layouts.app')

@section('title', 'Detail Produk - Toko HP')

@section('content')
<div class="mb-4">
    <h1 class="h3">Detail Produk</h1>
    <p class="text-muted">Informasi lengkap produk HP.</p>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Merk</dt>
            <dd class="col-sm-9">{{ $product->brand?->brand_name }}</dd>

            <dt class="col-sm-3">Model</dt>
            <dd class="col-sm-9">{{ $product->model_name }}</dd>

            <dt class="col-sm-3">Harga</dt>
            <dd class="col-sm-9">Rp {{ number_format($product->price, 0, ',', '.') }}</dd>

            <dt class="col-sm-3">Stok</dt>
            <dd class="col-sm-9">{{ $product->stock }}</dd>

            <dt class="col-sm-3">Tahun Rilis</dt>
            <dd class="col-sm-9">{{ $product->release_year ?? '-' }}</dd>

            <dt class="col-sm-3">Dibuat</dt>
            <dd class="col-sm-9">-</dd>

            <dt class="col-sm-3">Terakhir diperbarui</dt>
            <dd class="col-sm-9">-</dd>
        </dl>

        <div class="mt-4">
            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
