<?php

namespace App\Console\Commands;

use App\Models\JadwalPemeliharaan;
use App\Notifications\MaintenanceReminder;
use Illuminate\Console\Command;

class CheckMaintenanceReminder extends Command
{
    protected $signature = 'maintenance:check-reminder';
    protected $description = 'Cek jadwal pemeliharaan H-3 dan kirim notifikasi';

    public function handle()
    {
        $tanggalH3 = now()->addDays(3)->toDateString();

        $jadwals = JadwalPemeliharaan::whereDate('tanggal_mulai', $tanggalH3)
            ->where('reminder_h3', true)
            ->where('is_active', true)
            ->with('creator')
            ->get();

        foreach ($jadwals as $jadwal) {
            if ($jadwal->creator) {
                $jadwal->creator->notify(new MaintenanceReminder($jadwal));
            }
        }

        $this->info('Reminder checked. ' . $jadwals->count() . ' reminder(s) sent.');
    }
}