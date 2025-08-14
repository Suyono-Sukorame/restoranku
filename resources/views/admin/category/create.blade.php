@extends('admin.layouts.master')
@section('title', 'Tambah Kategori')

@section('css')
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tambah Kategori</h3>
                <p class="text-subtitle text-muted">Isi form berikut untuk menambahkan kategori baru.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <a href="{{ route('categories.index') }}" class="btn btn-secondary float-start float-lg-end">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="cat_name" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control @error('cat_name') is-invalid @enderror" 
                               id="cat_name" name="cat_name" value="{{ old('cat_name') }}" required>
                        @error('cat_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
@endsection
