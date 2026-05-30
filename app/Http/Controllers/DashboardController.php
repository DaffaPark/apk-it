<?php

namespace App\Http\Controllers;

use App\Models\JadwalPemeliharaan;
use App\Models\Tiket;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOpen = Tiket::whereIn('status', ['open', 'in_progress'])->count();
        $totalResolved = Tiket::where('status', 'resolved')->count();
        $totalClosed = Tiket::where('status', 'closed')->count();
        $tiketsTerbaru = Tiket::latest()->take(10)->get();

        // Ambil jadwal pemeliharaan mendatang (maks 5)
        $jadwalMendatang = JadwalPemeliharaan::where('is_active', true)
            ->where('tanggal_mulai', '>=', today())  // ← gunakan today() untuk hanya membandingkan tanggal
            ->orderBy('tanggal_mulai')
            ->take(5)
            ->get();

        $overdue = Tiket::whereNotIn('status', ['resolved', 'closed'])
        ->where('sla_deadline', '<', now())
        ->count();

        return view('admin.dashboard', compact(
            'totalOpen',
            'totalResolved',
            'totalClosed',
            'tiketsTerbaru',
            'jadwalMendatang',
            'overdue'
        ));
    }
}