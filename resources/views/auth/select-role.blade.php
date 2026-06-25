@extends('layouts.app')

@section('title', 'Login - Pilih Peran')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">Masuk sebagai</div>
            <div class="card-body">
                <p>Pilih peran untuk masuk:</p>
                <div class="d-grid gap-3">
                    <a href="{{ route('login.form', ['role' => 'customer']) }}" class="btn btn-outline-primary">Login Customer</a>
                    <a href="{{ route('login.form', ['role' => 'admin']) }}" class="btn btn-outline-secondary">Login Admin</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
