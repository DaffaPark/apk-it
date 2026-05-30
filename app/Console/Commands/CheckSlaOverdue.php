<?php

namespace App\Console\Commands;

use App\Models\Tiket;
use Illuminate\Console\Command;

class CheckSlaOverdue extends Command
{
    protected $signature = 'sla:check-overdue';
    protected $description = 'Cek tiket yang SLA-nya terlewat dan kirim notifikasi';

    public function handle()
    {
        $tikets = Tiket::whereNotIn('status', ['resolved', 'closed'])
            ->where('sla_deadline', '<', now())
            ->with('teknisi')
            ->get();

        foreach ($tikets as $tiket) {
            // Kirim notifikasi ke teknisi yang menangani
            if ($tiket->teknisi) {
                $tiket->teknisi->notify(new \App\Notifications\SlaOverdueNotification($tiket));
            }
            // Kirim juga ke kepala IT
            $kepalaIt = \App\Models\User::where('role', 'kepala_it')->first();
            if ($kepalaIt) {
                $kepalaIt->notify(new \App\Notifications\SlaOverdueNotification($tiket));
            }
        }

        $this->info(count($tikets) . ' tiket overdue ditemukan dan notifikasi dikirim.');
    }
}