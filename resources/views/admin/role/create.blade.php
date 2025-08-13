@extends('admin.layouts.master')
@section('title', 'Tambah Role')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/admin/extensions/select2/select2.min.css') }}">
@endsection

@section('content')
<div class="page-heading">
    <h3>Tambah Role Baru</h3>
    <p class="text-subtitle text-muted">Isi form di bawah untuk menambahkan role baru.</p>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="role_name" class="form-label">Role Name</label>
                        <input type="text" class="form-control @error('role_name') is-invalid @enderror" 
                               id="role_name" name="role_name" value="{{ old('role_name') }}" required>
                        @error('role_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Role</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
<script>
    // Bisa ditambahkan JS khusus jika diperlukan
</script>
@endsection
