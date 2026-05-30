<?php

namespace App\Notifications;

use App\Models\Tiket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TiketStatusUpdated extends Notification
{
    use Queueable;

    public function __construct(public Tiket $tiket) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $url = route('pantau', $this->tiket->kode_unik);

        return (new MailMessage)
            ->subject("Status Tiket #{$this->tiket->kode_unik} Diperbarui")
            ->greeting("Halo {$this->tiket->pelapor_nama},")
            ->line("Status tiket Anda kini: **" . ucwords(str_replace('_', ' ', $this->tiket->status)) . "**")
            ->line("Keluhan: {$this->tiket->keluhan}")
            ->line("Penyebab: " . ($this->tiket->penyebab ?? 'Belum diketahui'))
            ->line("Solusi: " . ($this->tiket->solusi ?? 'Belum ada'))
            ->action('Pantau Tiket', $url)
            ->line('Terima kasih telah menggunakan layanan IT RS.');
    }
}