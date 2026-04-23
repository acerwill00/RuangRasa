<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentReminder extends Notification
{
    use Queueable;

    public $appointment;

    /**
     * Create a new notification instance.
     */
    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $time = \Carbon\Carbon::parse($this->appointment->schedule_time)->format('h:i A');
        $psychologistName = $this->appointment->psychologist->name;

        return (new MailMessage)
                    ->subject('Reminder: Your Session is Starting Soon!')
                    ->greeting('Hello ' . $notifiable->name . ',')
                    ->line('This is a quick reminder that your session with ' . $psychologistName . ' is scheduled to start in 30 minutes at ' . $time . '.')
                    ->line('Please prepare yourself and ensure you are in a quiet, comfortable space.')
                    ->action('View Dashboard', url('/dashboard'))
                    ->line('Thank you for choosing Ruang Rasa!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
