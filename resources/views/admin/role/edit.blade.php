@extends('admin.layouts.master')
@section('title', 'Edit Role')

@section('content')
<div class="page-heading">
    <h3>Edit Role</h3>
    <p class="text-subtitle text-muted">Ubah data role sesuai kebutuhan.</p>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('roles.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="role_name" class="form-label">Role Name</label>
                        <input type="text" class="form-control @error('role_name') is-invalid @enderror" 
                               id="role_name" name="role_name" value="{{ old('role_name', $role->role_name) }}" required>
                        @error('role_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3" required>{{ old('description', $role->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update Role</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
