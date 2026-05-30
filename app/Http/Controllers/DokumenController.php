<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function index(Request $request)
    {
        $query = Dokumen::with('uploader');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('kategori_tag', 'like', '%' . $request->search . '%')
                  ->orWhere('versi', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $dokumens = $query->latest()->paginate(15);
        return view('admin.dokumen.index', compact('dokumens'));
    }

    public function create()
    {
        return view('admin.dokumen.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:250',
            'kategori_tag' => 'nullable|string|max:100',
            'versi' => 'nullable|string|max:20',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,png,zip|max:20480', // max 20MB
        ]);

        // Upload file
        $path = $request->file('file')->store('dokumen', 'public');

        // Set versi default jika kosong
        if (empty($validated['versi'])) {
            $validated['versi'] = '1.0';
        }

        // Nonaktifkan versi lama (jika ada dokumen dengan judul yang sama, is_versi_terbaru jadi false)
        Dokumen::where('judul', $validated['judul'])->update(['is_versi_terbaru' => false]);

        Dokumen::create([
            'judul' => $validated['judul'],
            'kategori_tag' => $validated['kategori_tag'],
            'versi' => $validated['versi'],
            'is_versi_terbaru' => true,
            'file_path' => $path,
            'uploaded_by' => auth()->id(),
            'status' => 'aktif',
        ]);

        return redirect()->route('admin.dokumen.index')
            ->with('success', 'Dokumen berhasil diunggah.');
    }

    public function show(Dokumen $dokumen)
    {
        return view('admin.dokumen.show', compact('dokumen'));
    }

    public function edit(Dokumen $dokumen)
    {
        return view('admin.dokumen.edit', compact('dokumen'));
    }

    public function update(Request $request, Dokumen $dokumen)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:250',
            'kategori_tag' => 'nullable|string|max:100',
            'versi' => 'nullable|string|max:20',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,png,zip|max:20480',
            'status' => 'nullable|in:aktif,arsip',
        ]);

        // Jika ada file baru, hapus file lama dan upload baru
        if ($request->hasFile('file')) {
            if ($dokumen->file_path) {
                Storage::disk('public')->delete($dokumen->file_path);
            }
            $validated['file_path'] = $request->file('file')->store('dokumen', 'public');
        }

        $dokumen->update($validated);

        return redirect()->route('admin.dokumen.index')
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Dokumen $dokumen)
    {
        // Hapus file fisik
        if ($dokumen->file_path) {
            Storage::disk('public')->delete($dokumen->file_path);
        }

        $dokumen->delete();
        return redirect()->route('admin.dokumen.index')
            ->with('success', 'Dokumen dihapus.');
    }

    public function download(Dokumen $dokumen)
    {
        if (!Storage::disk('public')->exists($dokumen->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($dokumen->file_path, $dokumen->judul . '.' . pathinfo($dokumen->file_path, PATHINFO_EXTENSION));
    }
}