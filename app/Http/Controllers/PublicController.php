<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Form lapor publik.
     */
    public function formLapor()
    {
        return view('public.form-lapor');
    }

    /**
     * Proses submit laporan dari publik.
     */
    public function submitLaporan(Request $request)
    {
        $validated = $request->validate([
            'pelapor_nama'  => 'required|string|max:100',
            'pelapor_email' => 'nullable|email|max:100',
            'pelapor_unit'  => 'required|string|max:100',
            'kategori'      => 'required|in:hardware,software,jaringan,akun_password,simrs,alat_medis,lainnya',
            'prioritas'     => 'required|in:low,medium,high,critical',
            'keluhan'       => 'required|string|min:10',
        ]);

        $tiket = Tiket::create($validated + ['status' => 'open']);

        return redirect()->route('pantau', $tiket->kode_unik)
            ->with('success', 'Laporan berhasil dikirim. Simpan kode tiket Anda: ' . $tiket->kode_unik);
    }

    /**
     * Halaman pantau tiket berdasarkan kode unik.
     */
    public function pantau($kode_unik)
    {
        $tiket = Tiket::with('riwayat')->where('kode_unik', $kode_unik)->firstOrFail();
        return view('public.pantau', compact('tiket'));
    }

    /**
     * Submit feedback dan rating untuk tiket yang sudah resolved.
     */
    public function submitFeedback(Request $request, Tiket $tiket)
    {
        $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:500',
        ]);

        $tiket->update([
            'feedback_rating'  => $request->rating,
            'feedback_catatan' => $request->komentar,
        ]);

        return back()->with('success', 'Terima kasih atas feedback Anda!');
    }
}