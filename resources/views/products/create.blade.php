@extends('layouts.app')

@section('title', 'Tambah Produk - Toko HP')

@section('content')
<div class="mb-4">
    <h1 class="h3">Tambah Produk Baru</h1>
    <p class="text-muted">Isi data produk HP baru untuk toko Anda.</p>
</div>

@include('partials.alerts')

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="brand_id" class="form-label">Merk</label>
                <select name="brand_id" id="brand_id" class="form-select @error('brand_id') is-invalid @enderror">
                    <option value="">Pilih merk</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->brand_id }}" {{ old('brand_id') == $brand->brand_id ? 'selected' : '' }}>{{ $brand->brand_name }}</option>
                    @endforeach
                </select>
                @error('brand_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="model_name" class="form-label">Nama Model</label>
                <input type="text" name="model_name" id="model_name" value="{{ old('model_name') }}" class="form-control @error('model_name') is-invalid @enderror">
                @error('model_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <label for="price" class="form-label">Harga</label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" class="form-control @error('price') is-invalid @enderror">
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="stock" class="form-label">Stok</label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" class="form-control @error('stock') is-invalid @enderror">
                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="release_year" class="form-label">Tahun Rilis</label>
                    <input type="number" name="release_year" id="release_year" value="{{ old('release_year') }}" class="form-control @error('release_year') is-invalid @enderror">
                    @error('release_year')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Produk</button>
            </div>
        </form>
    </div>
</div>
@endsection
