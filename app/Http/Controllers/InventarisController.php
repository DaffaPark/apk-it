<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Models\Vendor;
use Illuminate\Http\Request;

class InventarisController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventaris::with('vendor');

        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->status_kondisi) {
            $query->where('status_kondisi', $request->status_kondisi);
        }

        $inventaris = $query->latest()->paginate(15);
        return view('admin.inventaris.index', compact('inventaris'));
    }

    public function create()
    {
        $vendors = Vendor::all();
        $induks = Inventaris::where('jenis', 'induk')->get();
        return view('admin.inventaris.create', compact('vendors', 'induks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_qr' => 'required|string|unique:inventaris,kode_qr',
            'nama_perangkat' => 'required|string|max:150',
            'jenis' => 'required|in:induk,komponen',
            'induk_id' => 'nullable|exists:inventaris,id',
            'kategori' => 'required|in:pc,monitor,printer,server,jaringan,alat_medis,lainnya',
            'serial_number' => 'nullable|string',
            'model' => 'nullable|string',
            'status_kondisi' => 'required|in:baik,perlu_perhatian,rusak,disposal',
            'lokasi_gedung' => 'nullable|string',
            'lokasi_lantai' => 'nullable|string',
            'lokasi_ruangan' => 'nullable|string',
            'area_klinis' => 'boolean',
            'tanggal_pembelian' => 'nullable|date',
            'estimasi_masa_pakai_bulan' => 'nullable|integer',
            'garansi_berakhir' => 'nullable|date',
            'vendor_id' => 'nullable|exists:vendors,id',
        ]);

        Inventaris::create($validated);
        return redirect()->route('admin.inventaris.index')
            ->with('success', 'Perangkat berhasil ditambahkan.');
    }

    public function show(Inventaris $inventari) // Laravel otomatis mapping 'inventari' dari route model binding
    {
        $inventari->load('vendor', 'induk', 'komponen', 'riwayat.user');
        return view('admin.inventaris.show', compact('inventari'));
    }

    public function edit(Inventaris $inventari)
    {
        $vendors = Vendor::all();
        $induks = Inventaris::where('jenis', 'induk')->where('id', '!=', $inventari->id)->get();
        return view('admin.inventaris.edit', compact('inventari', 'vendors', 'induks'));
    }

    public function update(Request $request, Inventaris $inventari)
    {
        $validated = $request->validate([
            'kode_qr' => 'required|string|unique:inventaris,kode_qr,' . $inventari->id,
            'nama_perangkat' => 'required|string|max:150',
            'jenis' => 'required|in:induk,komponen',
            'induk_id' => 'nullable|exists:inventaris,id',
            'kategori' => 'required|in:pc,monitor,printer,server,jaringan,alat_medis,lainnya',
            'serial_number' => 'nullable|string',
            'model' => 'nullable|string',
            'status_kondisi' => 'required|in:baik,perlu_perhatian,rusak,disposal',
            'lokasi_gedung' => 'nullable|string',
            'lokasi_lantai' => 'nullable|string',
            'lokasi_ruangan' => 'nullable|string',
            'area_klinis' => 'boolean',
            'tanggal_pembelian' => 'nullable|date',
            'estimasi_masa_pakai_bulan' => 'nullable|integer',
            'garansi_berakhir' => 'nullable|date',
            'vendor_id' => 'nullable|exists:vendors,id',
        ]);

        $inventari->update($validated);
        return redirect()->route('admin.inventaris.index')
            ->with('success', 'Perangkat berhasil diperbarui.');
    }

    public function destroy(Inventaris $inventari)
    {
        $inventari->delete();
        return redirect()->route('admin.inventaris.index')
            ->with('success', 'Perangkat dihapus.');
    }
}