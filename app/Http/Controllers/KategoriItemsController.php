<?php

namespace App\Http\Controllers;

use App\Models\KategoriItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class KategoriItemsController extends Controller
{
    public function index(Request $request)
    {
        $query = KategoriItem::withCount('masterItems');

        if ($request->filled('nama')) {
            $query->where('nama', 'LIKE', '%' . $request->nama . '%');
        }
        if ($request->filled('kode')) {
            $query->where('kode', $request->kode);
        }

        $kategori_items = $query->orderBy('id')->paginate(15)->withQueryString();

        return view('kategori_items.index', compact('kategori_items'));
    }

    public function create()
    {
        return view('kategori_items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:50|unique:kategori_items,kode',
            'nama' => 'required|string|max:255',
        ]);

        KategoriItem::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
        ]);

        return redirect()->route('kategori-items.index')
                         ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(KategoriItem $kategoriItem)
    {
        // Eager load relasi untuk menghindari N+1 problem
        $kategoriItem->load('masterItems');
        return view('kategori_items.show', ['kategori' => $kategoriItem]);
    }

    public function edit(KategoriItem $kategoriItem)
    {
        return view('kategori_items.edit', ['kategori' => $kategoriItem]);
    }

    public function update(Request $request, KategoriItem $kategoriItem)
    {
        // ponytail: Validasi simpel tanpa FormRequest untuk menjaga controller tetap tipis namun works
        $request->validate([
            'kode' => 'required|string|max:50|unique:kategori_items,kode,' . $kategoriItem->id,
            'nama' => 'required|string|max:255',
        ]);

        $kategoriItem->update([
            'kode' => $request->kode,
            'nama' => $request->nama,
        ]);

        return redirect()->route('kategori-items.index')
                         ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(KategoriItem $kategoriItem)
    {
        $kategoriItem->delete();

        return redirect()->route('kategori-items.index')
                         ->with('success', 'Kategori berhasil dihapus.');
    }

    public function downloadPdf(KategoriItem $kategoriItem)
    {
        // Eager loading menghindari N+1 pada detail master items dalam PDF
        $kategoriItem->load('masterItems');

        $pdf = Pdf::loadView('kategori_items.pdf', [
            'kategori'   => $kategoriItem,
            'print_time' => now()->format('d-m-Y H:i'),
        ]);

        return $pdf->download('kategori-item-' . $kategoriItem->kode . '.pdf');
    }
}
