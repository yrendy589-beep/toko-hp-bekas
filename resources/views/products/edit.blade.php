@extends('layouts.app')

@section('title', 'Edit Produk - Toko HP')

@section('content')
<div class="mb-4">
    <h1 class="h3">Edit Produk</h1>
    <p class="text-muted">Perbarui informasi produk HP.</p>
</div>

@include('partials.alerts')

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="brand_id" class="form-label">Merk</label>
                <select name="brand_id" id="brand_id" class="form-select @error('brand_id') is-invalid @enderror">
                    <option value="">Pilih merk</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->brand_id }}" {{ old('brand_id', $product->brand_id) == $brand->brand_id ? 'selected' : '' }}>{{ $brand->brand_name }}</option>
                    @endforeach
                </select>
                @error('brand_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="brand_name" class="form-label">Merk Baru</label>
                <input type="text" name="brand_name" id="brand_name" value="{{ old('brand_name') }}" class="form-control @error('brand_name') is-invalid @enderror" placeholder="Ketik merk jika ingin menambahkan merk baru">
                <div class="form-text">Isi jika ingin menambahkan merk baru. Pilih merk di atas jika sudah ada.</div>
                @error('brand_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Foto Produk</label>
                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Atau tempel URL gambar dari Google di bawah.</div>
            </div>

            <div class="mb-3">
                <label for="image_url" class="form-label">URL Foto Produk</label>
                <input type="url" name="image_url" id="image_url" value="{{ old('image_url', preg_match('/^https?:\/\//', $product->image) ? $product->image : '') }}" class="form-control @error('image_url') is-invalid @enderror" placeholder="https://...">
                @error('image_url')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Preview Gambar</label>
                <div class="border rounded p-3 text-center" id="image-preview-container">
                    @php
                        $previewSrc = preg_match('/^https?:\/\//', old('image_url', $product->image)) ? old('image_url', $product->image) : ($product->image ? asset('storage/' . $product->image) : '');
                    @endphp
                    @if($previewSrc)
                        <img id="image-preview" src="{{ $previewSrc }}" alt="Preview" class="img-fluid rounded" style="max-height: 300px;">
                    @else
                        <span class="text-muted">Preview akan muncul di sini ketika file atau URL dipilih.</span>
                        <img id="image-preview" src="" alt="Preview" class="img-fluid d-none rounded" style="max-height: 300px;">
                    @endif
                </div>
            </div>

            <div class="mb-3">
                <label for="model_name" class="form-label">Nama Model</label>
                <input type="text" name="model_name" id="model_name" value="{{ old('model_name', $product->model_name) }}" class="form-control @error('model_name') is-invalid @enderror">
                @error('model_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <label for="price" class="form-label">Harga</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" class="form-control @error('price') is-invalid @enderror">
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="stock" class="form-label">Stok</label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" class="form-control @error('stock') is-invalid @enderror">
                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="release_year" class="form-label">Tahun Rilis</label>
                    <input type="number" name="release_year" id="release_year" value="{{ old('release_year', $product->release_year) }}" class="form-control @error('release_year') is-invalid @enderror">
                    @error('release_year')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update Produk</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('image');
        const urlInput = document.getElementById('image_url');
        const previewImage = document.getElementById('image-preview');
        const previewContainer = document.getElementById('image-preview-container');

        const updatePreview = function (src) {
            if (!src) {
                previewImage.src = '';
                previewImage.classList.add('d-none');
                previewContainer.querySelector('span')?.classList.remove('d-none');
                return;
            }

            previewImage.src = src;
            previewImage.onload = function () {
                previewImage.classList.remove('d-none');
                previewContainer.querySelector('span')?.classList.add('d-none');
            };
            previewImage.onerror = function () {
                previewImage.classList.add('d-none');
                if (previewContainer.querySelector('span')) {
                    previewContainer.querySelector('span').textContent = 'URL tidak valid atau gambar tidak dapat dimuat.';
                    previewContainer.querySelector('span').classList.remove('d-none');
                }
            };
        };

        fileInput.addEventListener('change', function () {
            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    updatePreview(e.target.result);
                };
                reader.readAsDataURL(fileInput.files[0]);
            }
        });

        urlInput.addEventListener('input', function () {
            if (!fileInput.files.length) {
                updatePreview(urlInput.value);
            }
        });
    });
</script>
@endsection
