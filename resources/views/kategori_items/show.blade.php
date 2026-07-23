@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="mb-2">
                <a href="{{ route('kategori-items.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
                <a href="{{ route('kategori-items.edit', $kategori->id) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('kategori-items.download-pdf', $kategori->id) }}" class="btn btn-primary">
                    Download PDF
                </a>
                <form method="POST"
                      action="{{ route('kategori-items.destroy', $kategori->id) }}"
                      class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                        Hapus
                    </button>
                </form>
            </div>

            <div class="card mb-3">
                <div class="card-header">Detail Kategori</div>
                <div class="card-body">
                    <table class="table table-borderless" style="max-width:400px">
                        <tr>
                            <th style="width:100px">Kode</th>
                            <td style="width:10px">:</td>
                            <td>{{ $kategori->kode }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>:</td>
                            <td>{{ $kategori->nama }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Master Items dalam Kategori ini
                    <span class="badge bg-secondary ms-1">{{ $kategori->masterItems->count() }}</span>
                </div>
                <div class="card-body">
                    @if($kategori->masterItems->isEmpty())
                        <p class="text-muted">Belum ada master item dalam kategori ini.</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Jenis</th>
                                    <th>Harga Beli</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kategori->masterItems as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->kode }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->jenis }}</td>
                                    <td>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('master-items.show', $item->id) }}"
                                           class="btn btn-info btn-sm">Detail</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
