<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SessionReminderNotification extends Notification
{
    use Queueable;

    public $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'appointment_id' => $this->appointment->id,
            'title' => 'Session Starting Soon',
            'message' => "Your session with {$this->appointment->psychologist->name} starts in 30 minutes at " . \Carbon\Carbon::parse($this->appointment->schedule_time)->format('H:i') . ".",
            'url' => url('/dashboard'),
        ];
    }
}
