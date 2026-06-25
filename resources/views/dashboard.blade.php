@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">Dashboard</div>
            <div class="card-body">
                <h5>Halo, {{ auth()->user()->name }}!</h5>
                <p>Anda masuk sebagai <strong>{{ ucfirst(auth()->user()->role) }}</strong>.</p>
                @if(auth()->user()->role === 'admin')
                    <p>Sebagai admin, Anda bisa mengelola produk dan melihat daftar produk.</p>
                @else
                    <p>Sebagai customer, Anda bisa melihat daftar produk dan melakukan browsing.</p>
                @endif
                <div class="mt-4">
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Lihat Produk</a>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('products.create') }}" class="btn btn-success">Tambah Produk</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
