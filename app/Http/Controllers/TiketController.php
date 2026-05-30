<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use App\Models\User;
use App\Notifications\TiketStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class TiketController extends Controller
{
    public function index(Request $request)
    {
        $query = Tiket::with('pelapor', 'teknisi');

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->prioritas) {
            $query->where('prioritas', $request->prioritas);
        }
        if ($request->teknisi_id) {
            $query->where('teknisi_id', $request->teknisi_id);
        }
        if ($request->dari_tanggal) {
            $query->whereDate('created_at', '>=', $request->dari_tanggal);
        }
        if ($request->sampai_tanggal) {
            $query->whereDate('created_at', '<=', $request->sampai_tanggal);
        }

        $tikets = $query->latest()->paginate(15);
        $teknisis = User::where('role', 'teknisi')->get();

        return view('admin.tikets.index', compact('tikets', 'teknisis'));
    }

    public function create()
    {
        $teknisis = User::where('role', 'teknisi')->get();
        return view('admin.tikets.create', compact('teknisis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pelapor_nama'  => 'required|string|max:100',
            'pelapor_email' => 'nullable|email|max:100',
            'pelapor_unit'  => 'required|string|max:100',
            'kategori'      => 'required|in:hardware,software,jaringan,akun_password,simrs,alat_medis,lainnya',
            'prioritas'     => 'required|in:low,medium,high,critical',
            'keluhan'       => 'required|string|min:10',
            'teknisi_id'    => 'nullable|exists:users,id',
        ]);

        $validated['status'] = 'open';
        Tiket::create($validated);

        return redirect()->route('admin.tikets.index')
            ->with('success', 'Tiket berhasil dibuat.');
    }

    public function show(Tiket $tiket)
    {
        $tiket->load('riwayat.user', 'komentars.user', 'teknisi', 'pelapor', 'insiden');
        $teknisis = User::where('role', 'teknisi')->get();
        return view('admin.tikets.show', compact('tiket', 'teknisis'));
    }

    public function edit(Tiket $tiket)
    {
        $teknisis = User::where('role', 'teknisi')->get();
        return view('admin.tikets.edit', compact('tiket', 'teknisis'));
    }

    public function update(Request $request, Tiket $tiket)
    {
        $validated = $request->validate([
            'pelapor_nama'  => 'required|string|max:100',
            'pelapor_email' => 'nullable|email|max:100',
            'pelapor_unit'  => 'required|string|max:100',
            'kategori'      => 'required|in:hardware,software,jaringan,akun_password,simrs,alat_medis,lainnya',
            'prioritas'     => 'required|in:low,medium,high,critical',
            'keluhan'       => 'required|string|min:10',
            'teknisi_id'    => 'nullable|exists:users,id',
            'penyebab'      => 'nullable|string',
            'solusi'        => 'nullable|string',
        ]);

        $tiket->update($validated);

        return redirect()->route('admin.tikets.show', $tiket)
            ->with('success', 'Tiket berhasil diperbarui.');
    }

    public function updateStatus(Request $request, Tiket $tiket)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
        ]);

        $oldStatus = $tiket->status;
        $newStatus = $request->status;

        $tiket->update([
            'status'      => $newStatus,
            'resolved_at' => $newStatus === 'resolved' ? now() : $tiket->resolved_at,
        ]);

        $tiket->riwayat()->create([
            'user_id'    => auth()->id(),
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'catatan'    => 'Status diubah oleh ' . auth()->user()->name,
        ]);

        if ($tiket->pelapor_email) {
            Notification::route('mail', $tiket->pelapor_email)
                ->notify(new TiketStatusUpdated($tiket));
        }

        return back()->with('success', 'Status tiket diperbarui.');
    }

    public function destroy(Tiket $tiket)
    {
        $tiket->delete();
        return redirect()->route('admin.tikets.index')
            ->with('success', 'Tiket dihapus.');
    }
}