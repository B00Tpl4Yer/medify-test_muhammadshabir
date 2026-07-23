<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
            margin: 0;
            padding: 0 30px;
        }
        .header {
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0 0 4px 0;
            font-size: 18px;
        }
        .header p {
            margin: 2px 0;
            color: #555;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .info-table th {
            width: 120px;
            text-align: left;
            font-weight: bold;
            padding: 3px 6px;
        }
        .info-table td {
            padding: 3px 6px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .items-table thead tr {
            background-color: #4a90d9;
            color: #fff;
        }
        .items-table th,
        .items-table td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            text-align: left;
        }
        .items-table tbody tr:nth-child(even) {
            background-color: #f2f7ff;
        }
        .items-table .text-right {
            text-align: right;
        }
        .section-title {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 6px;
            border-left: 4px solid #4a90d9;
            padding-left: 8px;
        }
        .footer {
            margin-top: 30px;
            border-top: 1px solid #ccc;
            padding-top: 8px;
            font-size: 10px;
            color: #888;
            text-align: right;
        }
        .badge {
            display: inline-block;
            background-color: #4a90d9;
            color: #fff;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 11px;
        }
        .empty-text {
            color: #888;
            font-style: italic;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Kategori Item</h2>
        <p>Sistem Manajemen Master Items</p>
    </div>

    {{-- Info Kategori --}}
    <table class="info-table">
        <tr>
            <th>Kode Kategori</th>
            <td>: {{ $kategori->kode }}</td>
        </tr>
        <tr>
            <th>Nama Kategori</th>
            <td>: {{ $kategori->nama }}</td>
        </tr>
        <tr>
            <th>Jumlah Item</th>
            <td>: <span class="badge">{{ $kategori->masterItems->count() }} item</span></td>
        </tr>
    </table>

    {{-- Tabel Master Items --}}
    <div class="section-title">Daftar Master Items</div>

    @if($kategori->masterItems->isEmpty())
        <p class="empty-text">Belum ada master item dalam kategori ini.</p>
    @else
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width:30px">#</th>
                    <th style="width:80px">Kode</th>
                    <th>Nama Item</th>
                    <th style="width:70px">Jenis</th>
                    <th style="width:110px">Harga Beli</th>
                    <th style="width:110px">Harga Jual</th>
                    <th>Supplier</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kategori->masterItems as $i => $item)
                @php
                    $harga_jual = (int) $item->harga_beli + (int) round($item->harga_beli * $item->laba / 100);
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->jenis }}</td>
                    <td class="text-right">Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($harga_jual, 0, ',', '.') }}</td>
                    <td>{{ $item->supplier }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        Dicetak pada: {{ $print_time }}
    </div>

</body>
</html>
