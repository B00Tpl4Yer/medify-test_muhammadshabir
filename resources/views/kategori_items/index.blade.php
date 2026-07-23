@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="mb-2">
                <a href="{{ route('kategori-items.create') }}" class="btn btn-secondary">+ Kategori Baru</a>
            </div>

            <div class="card">
                <div class="card-header">Daftar Kategori Items</div>
                <div class="card-body">

                    <form method="GET" action="{{ route('kategori-items.index') }}" class="mb-3">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Kode</label>
                                <input type="text" class="form-control" name="kode" value="{{ request('kode') }}">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" name="nama" value="{{ request('nama') }}">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary me-2">Filter</button>
                                <a href="{{ route('kategori-items.index') }}" class="btn btn-outline-secondary">Reset</a>
                            </div>
                        </div>
                    </form>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Jumlah Item</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kategori_items as $kategori)
                            <tr>
                                <td>{{ ($kategori_items->currentPage() - 1) * $kategori_items->perPage() + $loop->iteration }}</td>
                                <td>{{ $kategori->kode }}</td>
                                <td>{{ $kategori->nama }}</td>
                                <td>{{ $kategori->master_items_count }}</td>
                                <td>
                                    <a href="{{ route('kategori-items.show', $kategori->id) }}"
                                       class="btn btn-info btn-sm">Detail</a>
                                    <a href="{{ route('kategori-items.edit', $kategori->id) }}"
                                       class="btn btn-warning btn-sm">Edit</a>
                                    <form method="POST"
                                          action="{{ route('kategori-items.destroy', $kategori->id) }}"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $kategori_items->links() }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
