@extends('layouts.app')

@section('title', 'Toko HP - Beranda')

@section('content')
<div class="text-center py-5">
    <h1 class="display-5 mb-3">Selamat datang di Toko HP</h1>
    <p class="lead text-secondary mb-4">Kelola produk HP kamu dengan sistem CRUD yang sederhana dan cepat.</p>

    <div class="d-flex justify-content-center gap-3 flex-wrap">
        <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">Daftar Produk</a>
        <a href="{{ route('products.create') }}" class="btn btn-outline-secondary btn-lg">Tambah Produk</a>
    </div>
</div>

<div class="row justify-content-center mt-5">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="h5 mb-3">Menu Utama</h2>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">• Lihat semua produk</li>
                    <li class="list-group-item">• Tambah produk baru</li>
                    <li class="list-group-item">• Edit dan hapus produk</li>
                    <li class="list-group-item">• Detail informasi HP</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
