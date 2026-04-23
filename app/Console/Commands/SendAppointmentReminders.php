<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendAppointmentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminders to patients 30 minutes before their appointment';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $targetTime = \Carbon\Carbon::now()->addMinutes(30);

        $appointments = \App\Models\Appointment::with(['user', 'psychologist'])
            ->where('status', 'scheduled')
            ->where('is_reminded', false)
            ->where('schedule_date', $targetTime->toDateString())
            // Check if schedule_time is exactly in the minute we are checking
            ->whereRaw('substr(schedule_time, 1, 5) = ?', [$targetTime->format('H:i')])
            ->get();

        foreach ($appointments as $appointment) {
            $appointment->user->notify(new \App\Notifications\AppointmentReminder($appointment));
            $appointment->update(['is_reminded' => true]);
        }

        $this->info("Sent {$appointments->count()} reminders.");
    }
}
