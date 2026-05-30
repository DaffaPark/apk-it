<?php

namespace App\Notifications;

use App\Models\InsidenSiber;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class InsidenNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public InsidenSiber $insiden)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database']; // Bisa ditambah 'mail' jika perlu email
    }

    /**
     * Get the array representation of the notification (untuk database).
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title'   => '🚨 Insiden Siber Baru',
            'message' => "Insiden {$this->insiden->jenis_serangan} terdeteksi dengan severity {$this->insiden->severity}.",
            'insiden_id' => $this->insiden->id,
            'url' => route('admin.insiden-siber.show', $this->insiden),
        ];
    }
}