<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function formLapor()
    {
        return view('public.form-lapor');
    }

    public function submitLaporan(Request $request)
    {
        $validated = $request->validate([
            'pelapor_nama' => 'required|string|max:100',
            'pelapor_unit' => 'required|string|max:100',
            'kategori' => 'required|in:hardware,software,jaringan,akun_password,simrs,alat_medis,lainnya',
            'prioritas' => 'required|in:low,medium,high,critical',
            'keluhan' => 'required|string|min:10',
        ]);

        $tiket = Tiket::create($validated + ['status' => 'open']);

        return redirect()->route('pantau', $tiket->kode_unik)
            ->with('success', 'Laporan berhasil dikirim. Simpan kode tiket Anda.');
    }

    public function pantau($kode_unik)
    {
        $tiket = Tiket::where('kode_unik', $kode_unik)->firstOrFail();
        return view('public.pantau', compact('tiket'));
    }
}