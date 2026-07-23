@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="mb-2">
                <a href="{{ route('kategori-items.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
            </div>
            <div class="card">
                <div class="card-header">Edit Kategori</div>
                <div class="card-body">

                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('kategori-items.update', $kategori->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-2">
                            <label class="form-label">Kode <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('kode') is-invalid @enderror"
                                   name="kode" value="{{ old('kode', $kategori->kode) }}" required>
                            @error('kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('nama') is-invalid @enderror"
                                   name="nama" value="{{ old('nama', $kategori->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button class="btn btn-primary mt-3">Perbarui</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
