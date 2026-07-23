<?php

namespace App\Exports;

use App\Models\MasterItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MasterItemsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return MasterItem::with('kategoriItems')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Kategori',
            'Nama Items',
            'Nama Supplier',
            'Harga',
            'Laba (%)',
            'Harga Jual',
        ];
    }

    public function map($item): array
    {
        static $no = 0;
        $no++;

        $nama_kategori = $item->kategoriItems->pluck('nama')->implode(', ');
        $harga_jual    = (int) $item->harga_beli + (int) round($item->harga_beli * $item->laba / 100);

        return [
            $no,
            $nama_kategori,
            $item->nama,
            $item->supplier,
            $item->harga_beli,
            $item->laba,
            $harga_jual,
        ];
    }
}
