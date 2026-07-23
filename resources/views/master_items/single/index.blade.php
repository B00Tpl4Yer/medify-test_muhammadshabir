@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2">
                <a href="{{ route('master-items.index') }}" class="btn btn-secondary">Kembali ke Daftar Item</a>
            </div>
            <div class="card">
                <div class="card-header">Master Item</div>

                <div class="card-body">
                    @if($data->foto)
                    <div class="mb-3 text-center">
                        <img src="{{ asset('storage/' . $data->foto) }}" alt="Foto Item"
                             class="img-thumbnail" style="max-height:220px; object-fit:cover;">
                    </div>
                    @else
                    <div class="mb-3 text-center text-muted fst-italic">
                        <small>Tidak ada foto</small>
                    </div>
                    @endif

                    <table class="table table-borderless">
                        <tr>
                            <th style="width:130px">Kode</th>
                            <td style="width:10px">:</td>
                            <td>{{$data->kode}}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>:</td>
                            <td>{{$data->nama}}</td>
                        </tr>
                        <tr>
                            <th>Harga Beli</th>
                            <td>:</td>
                            <td>Rp {{ number_format($data->harga_beli, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Laba</th>
                            <td>:</td>
                            <td>{{$data->laba}}%</td>
                        </tr>
                        <tr>
                            <th>Harga Jual</th>
                            <td>:</td>
                            <td>Rp {{ number_format($data->harga_beli + $data->harga_beli * $data->laba / 100, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Supplier</th>
                            <td>:</td>
                            <td>{{$data->supplier}}</td>
                        </tr>
                        <tr>
                            <th>Jenis</th>
                            <td>:</td>
                            <td>{{$data->jenis}}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>:</td>
                            <td>
                                @forelse($data->kategoriItems as $kat)
                                    <span class="badge bg-secondary me-1">{{ $kat->nama }}</span>
                                @empty
                                    <span class="text-muted small">-</span>
                                @endforelse
                            </td>
                        </tr>
                    </table>
                    <a class="btn btn-info" href="{{ route('master-items.edit', $data->id) }}">Edit</a>
                    <form action="{{ route('master-items.destroy', $data->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?');">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
@endsection