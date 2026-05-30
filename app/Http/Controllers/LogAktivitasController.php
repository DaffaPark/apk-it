<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $query = LogAktivitas::with('user')->latest();

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->aksi) {
            $query->where('aksi', $request->aksi);
        }
        if ($request->nama_tabel) {
            $query->where('nama_tabel', $request->nama_tabel);
        }
        if ($request->dari_tanggal) {
            $query->whereDate('created_at', '>=', $request->dari_tanggal);
        }
        if ($request->sampai_tanggal) {
            $query->whereDate('created_at', '<=', $request->sampai_tanggal);
        }

        $logs   = $query->paginate(25);
        $users  = User::all();
        $tables = LogAktivitas::distinct()->pluck('nama_tabel');

        return view('admin.log-aktivitas.index', compact('logs', 'users', 'tables'));
    }

    public function show(LogAktivitas $logAktivitas)
    {
        $logAktivitas->load('user');
        return view('admin.log-aktivitas.show', compact('logAktivitas'));
    }
}