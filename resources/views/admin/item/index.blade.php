@extends('admin.layouts.master')
@section('title', 'Category')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/admin/extensions/simple-datatables/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/compiled/css/table-datatables.css') }}">
<style>
    /* Thumbnail seragam dan responsif */
    .thumbnail-img {
        width: 80px;
        height: 80px;
        object-fit: cover; /* Crop gambar agar pas kotak */
        border-radius: 0.25rem;
        border: 1px solid #dee2e6;
    }

    /* Table responsive */
    .table-responsive {
        overflow-x: auto;
    }

    /* Tombol kecil tetap rapi di layar kecil */
    @media (max-width: 576px) {
        .btn-sm {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
        .thumbnail-img {
            width: 60px;
            height: 60px;
        }
    }
</style>
@endsection

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Daftar Menu</h3>
                <p class="text-subtitle text-muted">Berbagai pilihan menu terbaik.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <a href="{{ route('items.create') }}" class="btn btn-primary float-start float-lg-end">
                    <i class="bi bi-plus"></i> Tambah Menu
                </a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body table-responsive">
                <table id="table1" class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Menu</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img 
                                    src="{{ $item->img && file_exists(public_path('assets/img/' . $item->img)) 
                                        ? asset('assets/img/' . $item->img) 
                                        : 'https://source.unsplash.com/80x80/?food' }}" 
                                    class="thumbnail-img"
                                    alt="Image of {{ $item->name ?? 'Item' }}">
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>{{ Str::limit($item->description, 15) }}</td>
                            <td>{{ 'Rp' . number_format($item->price, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge {{ $item->category->cat_name == 'Makanan' ? 'bg-warning' : 'bg-info' }}">
                                    {{ $item->category->cat_name }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $item->is_active == 1 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $item->is_active == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning btn-sm mb-1">
                                    <i class="bi bi-pencil"></i> Ubah
                                </a>
                                <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Apakah anda yakin ingin menghapus menu ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mb-1">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/admin/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
<script src="{{ asset('assets/admin/static/js/pages/simple-datatables.js') }}"></script>
@endsection
