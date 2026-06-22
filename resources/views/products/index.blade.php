@extends('layouts.app')

@section('title', 'Daftar Produk - Toko HP')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3">Daftar Produk</h1>
        <p class="text-muted">Kelola stok dan informasi HP di toko Anda.</p>
    </div>
    <a href="{{ route('products.create') }}" class="btn btn-success">Tambah Produk</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="mb-4">
    <form action="{{ route('products.index') }}" method="GET" class="d-flex gap-2">
        <input type="search" name="search" value="{{ $search ?? '' }}" class="form-control" placeholder="Cari merk atau model...">
        <button type="submit" class="btn btn-primary">Cari</button>
    </form>
</div>

<form action="{{ route('products.bulk-delete') }}" method="POST" id="bulk-delete-form">
    @csrf
    @method('DELETE')

    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="select-all-products">
            <label class="form-check-label" for="select-all-products">Centang semua</label>
        </div>
        <div>
            <small class="text-muted">Pilih produk untuk tindakan cepat.</small>
        </div>
    </div>

    <div class="row g-4">
    @forelse($products as $product)
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body d-flex flex-column">
                    <div class="form-check mb-3">
                        <input class="form-check-input product-checkbox" type="checkbox" name="selected_products[]" value="{{ $product->product_id }}" id="product-{{ $product->product_id }}">
                        <label class="form-check-label" for="product-{{ $product->product_id }}">Pilih produk</label>
                    </div>
                    <div class="mb-3 text-center">
                        @if($product->image)
                            @php
                                $imageUrl = preg_match('/^https?:\/\//', $product->image) ? $product->image : asset('storage/' . $product->image);
                            @endphp
                            <img src="{{ $imageUrl }}" alt="{{ $product->model_name }}" class="img-fluid rounded-4" style="height:180px; width:auto; max-width:100%; object-fit:contain;">
                        @else
                            <div class="bg-light rounded-4 d-flex align-items-center justify-content-center" style="height:180px;">
                                <span class="text-muted">No image</span>
                            </div>
                        @endif
                    </div>

                    <h5 class="card-title mb-1">{{ $product->model_name }}</h5>
                    <p class="text-muted mb-2" style="font-size:0.95rem;">{{ $product->brand?->brand_name }}</p>
                    <div class="mb-3">
                        <span class="badge bg-success">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-secondary" style="font-size:0.9rem;">Stok: {{ $product->stock }}</span>
                        <span class="text-secondary" style="font-size:0.9rem;">{{ $product->release_year ?? '-' }}</span>
                    </div>

                    <div class="mt-auto d-grid gap-2">
                        <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary btn-sm">Lihat</a>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-warning btn-sm">Edit</a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info mb-0">Belum ada produk. Silakan tambahkan produk terlebih dahulu.</div>
        </div>
    @endforelse
</div>

    <div class="mt-4 d-flex justify-content-between align-items-center">
        <button type="submit" class="btn btn-danger" id="delete-selected-button" disabled>Hapus Produk Terpilih</button>
        <div>
            {{ $products->links() }}
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAll = document.getElementById('select-all-products');
        const checkboxes = document.querySelectorAll('.product-checkbox');
        const deleteButton = document.getElementById('delete-selected-button');

        const updateDeleteButton = function () {
            const anyChecked = Array.from(checkboxes).some(function (checkbox) {
                return checkbox.checked;
            });
            deleteButton.disabled = !anyChecked;
        };

        if (selectAll) {
            selectAll.addEventListener('change', function () {
                checkboxes.forEach(function (checkbox) {
                    checkbox.checked = selectAll.checked;
                });
                updateDeleteButton();
            });
        }

        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                if (!checkbox.checked && selectAll.checked) {
                    selectAll.checked = false;
                }
                updateDeleteButton();
            });
        });

        document.getElementById('bulk-delete-form').addEventListener('submit', function (event) {
            if (!confirm('Yakin ingin menghapus produk yang dipilih?')) {
                event.preventDefault();
            }
        });

        updateDeleteButton();
    });
</script>
@endsection
