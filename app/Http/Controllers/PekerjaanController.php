<?php

namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use App\Models\User;
use Illuminate\Http\Request;

class PekerjaanController extends Controller
{
    public function kanban(Request $request)
    {
        $pekerjaans = Pekerjaan::with(['assignee', 'tiket'])
            ->when($request->prioritas, fn($q) => $q->where('prioritas', $request->prioritas))
            ->get()
            ->groupBy('status');

        $teknisis = User::where('role', 'teknisi')->get();
        $totalToDo = $pekerjaans->get('to_do', collect())->count();
        $totalInProgress = $pekerjaans->get('in_progress', collect())->count();
        $totalDone = $pekerjaans->get('done', collect())->count();

        return view('admin.pekerjaan.kanban', compact(
            'pekerjaans',
            'teknisis',
            'totalToDo',
            'totalInProgress',
            'totalDone'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:200',
            'prioritas' => 'nullable|in:low,medium,high,critical',
            'assignee_id' => 'nullable|exists:users,id',
            'deadline' => 'nullable|date',
            'deskripsi' => 'nullable|string',
        ]);

        $validated['status'] = 'to_do';
        Pekerjaan::create($validated);

        return back()->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function updateStatus(Request $request, Pekerjaan $pekerjaan)
    {
        $request->validate([
            'status' => 'required|in:to_do,in_progress,done',
        ]);

        $pekerjaan->update([
            'status' => $request->status,
            'completed_at' => $request->status === 'done' ? now() : null,
        ]);

        return response()->json(['success' => true]);
    }
}