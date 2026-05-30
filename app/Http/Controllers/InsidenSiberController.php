<?php

namespace App\Http\Controllers;

use App\Models\InsidenSiber;
use App\Models\Tiket;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\InsidenNotification;

class InsidenSiberController extends Controller
{
    public function index(Request $request)
    {
        $query = InsidenSiber::with('tiket');

        if ($request->dari_tanggal) {
            $query->whereDate('detected_at', '>=', $request->dari_tanggal);
        }
        if ($request->sampai_tanggal) {
            $query->whereDate('detected_at', '<=', $request->sampai_tanggal);
        }
        if ($request->severity) {
            $query->where('severity', $request->severity);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $insidens = $query->latest()->paginate(15);
        return view('admin.insiden-siber.index', compact('insidens'));
    }

    public function create()
    {
        return view('admin.insiden-siber.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_serangan' => 'required|string|max:100',
            'sumber_ip'      => 'nullable|ip',
            'detail'         => 'nullable|string',
            'severity'       => 'required|in:low,medium,high,critical',
            'status'         => 'required|in:terdeteksi,dalam_penanganan,selesai,false_positive',
        ]);

        // 1. Buat tiket otomatis
        $tiket = \App\Models\Tiket::create([
            'pelapor_nama' => 'Sistem Deteksi',
            'pelapor_unit' => 'IT Security',
            'keluhan'      => "Insiden Siber Terdeteksi: {$validated['jenis_serangan']}\n\nDetail: {$validated['detail']}",
            'prioritas'    => $validated['severity'], // severity insiden = prioritas tiket
            'kategori'     => 'jaringan', // atau 'lainnya', sesuaikan
            'status'       => 'open',
            'teknisi_id'   => null, // biarkan kosong, nanti di-assign manual
        ]);

        // 2. Buat insiden dengan menyertakan tiket_id
        $validated['tiket_id'] = $tiket->id;
        $insiden = InsidenSiber::create($validated);

        // 3. Kirim notifikasi ke semua user IT
        $users = \App\Models\User::whereIn('role', ['super_admin', 'kepala_it', 'teknisi'])->get();
        foreach ($users as $user) {
            $user->notify(new \App\Notifications\InsidenNotification($insiden));
        }

        return redirect()->route('admin.insiden-siber.index')
            ->with('success', 'Insiden berhasil dicatat. Tiket #' . $tiket->kode_unik . ' otomatis dibuat.');
    }

    public function show(InsidenSiber $insidenSiber)
    {
        $insidenSiber->load('tiket', 'logs.user');
        return view('admin.insiden-siber.show', compact('insidenSiber'));
    }

    public function edit(InsidenSiber $insidenSiber)
    {
        return view('admin.insiden-siber.edit', compact('insidenSiber'));
    }

    public function update(Request $request, InsidenSiber $insidenSiber)
    {
        $validated = $request->validate([
            'jenis_serangan' => 'required|string|max:100',
            'sumber_ip'      => 'nullable|ip',
            'detail'         => 'nullable|string',
            'severity'       => 'required|in:low,medium,high,critical',
            'status'         => 'required|in:terdeteksi,dalam_penanganan,selesai,false_positive',
            'tiket_id'       => 'nullable|exists:tikets,id',
        ]);

        // Catat perubahan status
        if ($insidenSiber->status !== $validated['status']) {
            $insidenSiber->logs()->create([
                'user_id' => auth()->id(),
                'aksi'    => 'Status diubah: ' . $insidenSiber->status . ' → ' . $validated['status'],
            ]);
        }

        $insidenSiber->update($validated);

        return redirect()->route('admin.insiden-siber.index')
            ->with('success', 'Insiden diperbarui.');
    }

    public function destroy(InsidenSiber $insidenSiber)
    {
        $insidenSiber->delete();
        return redirect()->route('admin.insiden-siber.index')
            ->with('success', 'Insiden dihapus.');
    }
}