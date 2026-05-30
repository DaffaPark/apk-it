<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use App\Models\User;
use Illuminate\Http\Request;

class TiketController extends Controller
{
    // Daftar semua tiket (bisa filter status, prioritas)
    public function index(Request $request)
    {
        $query = Tiket::with('pelapor', 'teknisi');

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->prioritas) {
            $query->where('prioritas', $request->prioritas);
        }

        $tikets = $query->latest()->paginate(15);
        return view('admin.tikets.index', compact('tikets'));
    }

    // Form create tiket (oleh admin/teknisi)
    public function create()
    {
        $teknisis = User::where('role', 'teknisi')->get();
        return view('admin.tikets.create', compact('teknisis'));
    }

    // Simpan tiket baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pelapor_nama' => 'required|string|max:100',
            'pelapor_unit' => 'required|string|max:100',
            'kategori' => 'required|in:hardware,software,jaringan,akun_password,simrs,alat_medis,lainnya',
            'prioritas' => 'required|in:low,medium,high,critical',
            'keluhan' => 'required|string|min:10',
            'teknisi_id' => 'nullable|exists:users,id',
        ]);

        $validated['status'] = 'open';
        Tiket::create($validated);

        return redirect()->route('admin.tikets.index')
            ->with('success', 'Tiket berhasil dibuat.');
    }

    // Detail tiket (untuk admin/teknisi)
    public function show(Tiket $tiket)
    {
        $tiket->load('riwayat.user', 'komentars.user', 'teknisi', 'pelapor');
        $teknisis = User::where('role', 'teknisi')->get();
        return view('admin.tikets.show', compact('tiket', 'teknisis'));
    }

    // Form edit tiket
    public function edit(Tiket $tiket)
    {
        $teknisis = User::where('role', 'teknisi')->get();
        return view('admin.tikets.edit', compact('tiket', 'teknisis'));
    }

    // Update tiket (selain status)
    public function update(Request $request, Tiket $tiket)
    {
        $validated = $request->validate([
            'pelapor_nama' => 'required|string|max:100',
            'pelapor_unit' => 'required|string|max:100',
            'kategori' => 'required|in:hardware,software,jaringan,akun_password,simrs,alat_medis,lainnya',
            'prioritas' => 'required|in:low,medium,high,critical',
            'keluhan' => 'required|string|min:10',
            'teknisi_id' => 'nullable|exists:users,id',
            'penyebab' => 'nullable|string',
            'solusi' => 'nullable|string',
        ]);

        $tiket->update($validated);

        // Catat di riwayat? Bisa nanti
        return redirect()->route('admin.tikets.show', $tiket)
            ->with('success', 'Tiket berhasil diperbarui.');
    }

    // Ubah status tiket (via tombol cepat)
    public function updateStatus(Request $request, Tiket $tiket)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
        ]);

        $oldStatus = $tiket->status;
        $newStatus = $request->status;

        $tiket->update([
            'status' => $newStatus,
            'resolved_at' => $newStatus === 'resolved' ? now() : $tiket->resolved_at,
        ]);

        // Simpan riwayat
        $tiket->riwayat()->create([
            'user_id' => auth()->id(),
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'catatan' => 'Status diubah oleh ' . auth()->user()->name,
        ]);

        return back()->with('success', 'Status tiket diperbarui.');
    }

    // Hapus tiket
    public function destroy(Tiket $tiket)
    {
        $tiket->delete();
        return redirect()->route('admin.tikets.index')
            ->with('success', 'Tiket dihapus.');
    }
}