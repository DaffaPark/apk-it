<?php

namespace App\Http\Controllers;

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

        return view('admin.dashboard', compact(
            'totalOpen', 'totalResolved', 'totalClosed', 'tiketsTerbaru'
        ));
    }
}