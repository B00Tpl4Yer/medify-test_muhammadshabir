<form method="POST" action="{{ $method == 'edit' ? route('master-items.update', $item->id ?? 0) : route('master-items.store') }}" enctype="multipart/form-data">
    @csrf
    @if($method == 'edit')
        @method('PUT')
    @endif
    <div class="form-group mb-2">
        <label>Kode Barang</label>
        <input type="text" class="form-control" name="kode_barang" required readonly value="{{ $item->kode ?? '' }}">
    </div>

    <div class="form-group mb-2">
        <label>Nama</label>
        <input type="text" class="form-control" name="nama" required value="{{ $item->nama ?? '' }}">
    </div>

    <div class="form-group mb-2">
        <label>Harga Beli</label>
        <input type="number" class="form-control" name="harga_beli" required min="0" value="{{ $item->harga_beli ?? '' }}">
    </div>

    <div class="form-group mb-2">
        <label>Laba (dalam persen)</label>
        <input type="number" class="form-control" name="laba" required min="0" max="100" value="{{ $item->laba ?? '' }}">
    </div>

    @php $selectedSupplier = $item->supplier ?? ''; @endphp
    <div class="form-group mb-2">
        <label>Supplier</label>
        <select class="form-control" required name="supplier">
            <option value="" @if($selectedSupplier == '') selected @endif>--Pilih--</option>
            <option @if($selectedSupplier == 'Tokopaedi') selected @endif>Tokopaedi</option>
            <option @if($selectedSupplier == 'Bukulapuk') selected @endif>Bukulapuk</option>
            <option @if($selectedSupplier == 'TokoBagas') selected @endif>TokoBagas</option>
            <option @if($selectedSupplier == 'E Commurz') selected @endif>E Commurz</option>
            <option @if($selectedSupplier == 'Blublu') selected @endif>Blublu</option>
        </select>
    </div>

    @php $selectedJenis = $item->jenis ?? ''; @endphp
    <div class="form-group mb-2">
        <label>Jenis</label>
        <select class="form-control" required name="jenis">
            <option value="" @if($selectedJenis == '') selected @endif>--Pilih--</option>
            <option @if($selectedJenis == 'Obat') selected @endif>Obat</option>
            <option @if($selectedJenis == 'Alkes') selected @endif>Alkes</option>
            <option @if($selectedJenis == 'Matkes') selected @endif>Matkes</option>
            <option @if($selectedJenis == 'Umum') selected @endif>Umum</option>
            <option @if($selectedJenis == 'ATK') selected @endif>ATK</option>
        </select>
    </div>

    <div class="form-group mb-2">
        <label>Foto Item</label>
        @if($method == 'edit' && !empty($item->foto))
        <div class="mb-2">
            <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Item"
                 class="img-thumbnail" style="height:120px; object-fit:cover;">
            <p class="text-muted small mt-1">Kosongkan jika tidak ingin mengubah foto.</p>
        </div>
        @endif
        <input type="file" class="form-control" name="foto" accept=".jpg,.jpeg,.png">
        @error('foto')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-2">
        <label>Kategori</label>
        @if($all_kategori->isEmpty())
            <p class="text-muted small mb-0">
                Belum ada kategori tersedia.
                <a href="{{ route('kategori-items.create') }}">Buat kategori baru</a>.
            </p>
        @else
        <select class="form-select" name="kategori_item_ids[]" multiple
                size="{{ min(6, $all_kategori->count()) }}">
            @foreach($all_kategori as $kat)
            <option value="{{ $kat->id }}"
                @if(in_array($kat->id, $selected_kategori_ids ?? [])) selected @endif>
                {{ $kat->kode }} &ndash; {{ $kat->nama }}
            </option>
            @endforeach
        </select>
        <small class="text-muted">Tahan <kbd>Ctrl</kbd> untuk memilih lebih dari satu.</small>
        @endif
    </div>

    <button class="btn btn-primary mt-3">Submit</button>
</form>