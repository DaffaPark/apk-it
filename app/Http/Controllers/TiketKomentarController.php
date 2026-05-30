<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use App\Models\TiketKomentar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TiketKomentarController extends Controller
{
    public function storeAdmin(Request $request, Tiket $tiket)
    {
        $validated = $request->validate([
            'pesan'    => 'required_without:lampiran|string|max:1000',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf|max:5120',
        ]);

        $komentar = new TiketKomentar([
            'tiket_id' => $tiket->id,
            'user_id'  => auth()->id(),
            'pesan'    => $validated['pesan'] ?? '',
        ]);

        if ($request->hasFile('lampiran')) {
            $komentar->lampiran_url = $request->file('lampiran')->store('tiket-bukti', 'public');
        }

        $komentar->save();

        return back()->with('success', 'Komentar terkirim.');
    }

    public function storePublic(Request $request, $kode_unik)
    {
        $tiket = Tiket::where('kode_unik', $kode_unik)->firstOrFail();

        $validated = $request->validate([
            'pesan' => 'required|string|max:1000',
        ]);

        TiketKomentar::create([
            'tiket_id' => $tiket->id,
            'user_id'  => null,
            'pesan'    => $validated['pesan'],
        ]);

        return back()->with('success', 'Balasan terkirim.');
    }
}