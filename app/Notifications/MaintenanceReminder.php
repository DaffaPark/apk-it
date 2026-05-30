<?php

namespace App\Notifications;

use App\Models\JadwalPemeliharaan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;

class MaintenanceReminder extends Notification
{
    use Queueable;

    public function __construct(public JadwalPemeliharaan $jadwal) {}

    public function via($notifiable): array
    {
        return ['database']; // bisa ditambah 'mail' jika perlu
    }

    public function toDatabase($notifiable): array
    {
        return [
            'message' => "Reminder H-3: Pemeliharaan '{$this->jadwal->nama}' pada {$this->jadwal->tanggal_mulai->format('d/m/Y')}",
            'jadwal_id' => $this->jadwal->id,
            'tanggal_mulai' => $this->jadwal->tanggal_mulai,
        ];
    }
}