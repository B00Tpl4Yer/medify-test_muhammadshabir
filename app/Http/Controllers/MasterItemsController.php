<?php

namespace App\Http\Controllers;

use App\Exports\MasterItemsExport;
use App\Models\KategoriItem;
use App\Models\MasterItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class MasterItemsController extends Controller
{
    public function index()
    {
        return view('master_items.index.index');
    }

    public function exportExcel()
    {
        return Excel::download(new MasterItemsExport(), 'master-items.xlsx');
    }

    public function search(Request $request)
    {
        $request->validate([
            'kode'     => 'nullable|string|max:50',
            'nama'     => 'nullable|string|max:255',
            'hargamin' => 'nullable|numeric|min:0',
            'hargamax' => 'nullable|numeric|min:0',
        ]);

        $kode     = $request->kode;
        $nama     = $request->nama;
        $hargamin = $request->hargamin;
        $hargamax = $request->hargamax;

        $data_search = MasterItem::query();

        if (!empty($kode)) $data_search = $data_search->where('kode', $kode);
        if (!empty($nama)) $data_search = $data_search->where('nama', 'LIKE', '%' . $nama . '%');

        if ($request->filled('hargamin')) {
            $data_search = $data_search->where('harga_beli', '>=', (int) $hargamin);
        }
        if ($request->filled('hargamax')) {
            $data_search = $data_search->where('harga_beli', '<=', (int) $hargamax);
        }

        $data_search = $data_search
            ->with('kategoriItems')
            ->select('id', 'kode', 'nama', 'jenis', 'harga_beli', 'laba', 'supplier', 'foto')
            ->orderBy('id')
            ->get();

        return json_encode([
            'status' => 200,
            'data'   => $data_search
        ]);
    }

    public function create()
    {
        $all_kategori = KategoriItem::orderBy('nama')->get();
        return view('master_items.form.index', [
            'method' => 'new',
            'item' => null,
            'all_kategori' => $all_kategori,
            'selected_kategori_ids' => []
        ]);
    }

    public function store(Request $request)
    {
        // ponytail: validasi langsung di controller agar tetap minimal & YAGNI tanpa FormRequest berlebih
        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'harga_beli' => 'required|integer|min:0',
            'laba'       => 'required|integer|min:0|max:100',
            'supplier'   => 'required|string',
            'jenis'      => 'required|string',
            'foto'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'kategori_item_ids'   => 'nullable|array',
            'kategori_item_ids.*' => 'exists:kategori_items,id',
        ]);

        $kode = MasterItem::withTrashed()->max('id') ?? 0;
        $validated['kode'] = str_pad((string)($kode + 1), 5, '0', STR_PAD_LEFT);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('items', 'public');
        }

        $item = MasterItem::create($validated);
        $item->kategoriItems()->sync($request->kategori_item_ids ?? []);

        return redirect()->route('master-items.index');
    }

    public function show(MasterItem $masterItem)
    {
        $masterItem->load('kategoriItems');
        return view('master_items.single.index', ['data' => $masterItem]);
    }

    public function edit(MasterItem $masterItem)
    {
        $all_kategori = KategoriItem::orderBy('nama')->get();
        $masterItem->load('kategoriItems');

        return view('master_items.form.index', [
            'method' => 'edit',
            'item' => $masterItem,
            'all_kategori' => $all_kategori,
            'selected_kategori_ids' => $masterItem->kategoriItems->pluck('id')->toArray()
        ]);
    }

    public function update(Request $request, MasterItem $masterItem)
    {
        // ponytail: validasi langsung di controller agar tetap minimal
        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'harga_beli' => 'required|integer|min:0',
            'laba'       => 'required|integer|min:0|max:100',
            'supplier'   => 'required|string',
            'jenis'      => 'required|string',
            'foto'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'kategori_item_ids'   => 'nullable|array',
            'kategori_item_ids.*' => 'exists:kategori_items,id',
        ]);

        if ($request->hasFile('foto')) {
            if ($masterItem->foto) {
                Storage::disk('public')->delete($masterItem->foto);
            }
            $validated['foto'] = $request->file('foto')->store('items', 'public');
        }

        $masterItem->update($validated);
        $masterItem->kategoriItems()->sync($request->kategori_item_ids ?? []);

        return redirect()->route('master-items.index');
    }

    public function destroy(MasterItem $masterItem)
    {
        if ($masterItem->foto) {
            Storage::disk('public')->delete($masterItem->foto);
        }
        $masterItem->delete();
        return redirect()->route('master-items.index');
    }

    public function updateRandomData()
    {
        $data = MasterItem::get();
        foreach($data as $item)
        {
            $kode = $item->id;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

            $item->harga_beli = rand(100,1000000);
            $item->laba = rand(10,99);
            $item->kode = $kode;
            $item->supplier = $this->getRandomSupplier();
            $item->jenis = $this->getRandomJenis();
            $item->save();
        }
    }

    private function getRandomSupplier()
    {
        $array = ['Tokopaedi','Bukulapuk','TokoBagas','E Commurz','Blublu'];
        $random = rand(0,4);
        return $array[$random];
    }

    private function getRandomJenis()
    {
        $array = ['Obat','Alkes','Matkes','Umum','ATK'];
        $random = rand(0,4);
        return $array[$random];
    }
}
