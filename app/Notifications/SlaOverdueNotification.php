<?php

namespace App\Notifications;

use App\Models\Tiket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SlaOverdueNotification extends Notification
{
    use Queueable;

    public function __construct(public Tiket $tiket) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'title'   => '⏰ SLA Overdue',
            'message' => "Tiket #{$this->tiket->kode_unik} ({$this->tiket->prioritas}) melewati deadline SLA.",
            'url'     => route('admin.tikets.show', $this->tiket),
        ];
    }
}