<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Models\JadwalPemeliharaan;
use Illuminate\Http\Request;

class JadwalPemeliharaanController extends Controller
{
    public function index()
    {
        $jadwals = JadwalPemeliharaan::with('inventaris', 'creator')
            ->latest()
            ->paginate(15);
        return view('admin.jadwal-pemeliharaan.index', compact('jadwals'));
    }

    public function create()
    {
        // Buat instance kosong untuk menghindari error undefined variable
        $jadwalPemeliharaan = new JadwalPemeliharaan();
        $inventaris = Inventaris::all();
        return view('admin.jadwal-pemeliharaan.create', compact('jadwalPemeliharaan', 'inventaris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:200',
            'jenis' => 'required|in:rutin,sekali',
            'frekuensi_hari' => 'nullable|integer|min:1',
            'tanggal_mulai' => 'required|date',
            'inventaris_id' => 'nullable|exists:inventaris,id',
            'reminder_h3' => 'boolean',
            'checklist_json' => 'nullable|json',
            'is_active' => 'boolean',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['checklist_json'] = json_decode($validated['checklist_json'] ?? '[]', true);

        JadwalPemeliharaan::create($validated);

        return redirect()->route('admin.jadwal-pemeliharaan.index')
            ->with('success', 'Jadwal pemeliharaan berhasil dibuat.');
    }

    public function edit(JadwalPemeliharaan $jadwalPemeliharaan)
    {
        $inventaris = Inventaris::all();
        return view('admin.jadwal-pemeliharaan.edit', compact('jadwalPemeliharaan', 'inventaris'));
    }

    public function update(Request $request, JadwalPemeliharaan $jadwalPemeliharaan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:200',
            'jenis' => 'required|in:rutin,sekali',
            'frekuensi_hari' => 'nullable|integer|min:1',
            'tanggal_mulai' => 'required|date',
            'inventaris_id' => 'nullable|exists:inventaris,id',
            'reminder_h3' => 'boolean',
            'checklist_json' => 'nullable|json',
            'is_active' => 'boolean',
        ]);

        $validated['checklist_json'] = json_decode($validated['checklist_json'] ?? '[]', true);

        $jadwalPemeliharaan->update($validated);

        return redirect()->route('admin.jadwal-pemeliharaan.index')
            ->with('success', 'Jadwal pemeliharaan berhasil diperbarui.');
    }

    public function destroy(JadwalPemeliharaan $jadwalPemeliharaan)
    {
        $jadwalPemeliharaan->delete();
        return redirect()->route('admin.jadwal-pemeliharaan.index')
            ->with('success', 'Jadwal dihapus.');
    }
}