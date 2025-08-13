@extends('admin.layouts.master')
@section('title', 'Edit Menu')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/admin/extensions/select2/select2.min.css') }}">
<style>
    .preview-img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        margin-bottom: 10px;
    }
</style>
@endsection

@section('content')
<div class="page-heading">
    <h3>Edit Menu</h3>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Menu</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $item->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" id="description" rows="3">{{ old('description', $item->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Harga</label>
                        <input type="number" name="price" class="form-control" id="price" value="{{ old('price', $item->price) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Kategori</label>
                        <select name="category_id" class="form-select" id="category_id" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->cat_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="is_active" class="form-label">Status</label>
                        <select name="is_active" class="form-select" id="is_active" required>
                            <option value="1" {{ old('is_active', $item->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active', $item->is_active) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="img" class="form-label">Gambar</label>
                        <input type="file" name="img" class="form-control" id="img" accept="image/*" onchange="previewImage(event)">
                        <img id="preview" src="{{ $item->img && file_exists(public_path('assets/img/' . $item->img)) ? asset('assets/img/' . $item->img) : asset('assets/img/no_image.jpg') }}" class="preview-img">
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('items.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        const output = document.getElementById('preview');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection
