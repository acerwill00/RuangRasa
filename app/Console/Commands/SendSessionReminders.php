<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Notifications\SessionReminderNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendSessionReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-session-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send automated 30-minute reminders for scheduled appointments';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Find appointments scheduled exactly 30 minutes from now (ignoring seconds)
        // Since this runs every minute, we check between 29.5 and 30.5 minutes or just exactly matching the minute.
        
        $targetTimeStart = Carbon::now()->addMinutes(30)->startOfMinute();
        $targetTimeEnd = Carbon::now()->addMinutes(30)->endOfMinute();

        $appointments = Appointment::where('status', 'scheduled')
            ->where('is_reminded', false)
            ->where('schedule_date', $targetTimeStart->toDateString())
            ->whereTime('schedule_time', '>=', $targetTimeStart->format('H:i:s'))
            ->whereTime('schedule_time', '<=', $targetTimeEnd->format('H:i:s'))
            ->get();

        foreach ($appointments as $appointment) {
            $appointment->user->notify(new SessionReminderNotification($appointment));
            $appointment->update(['is_reminded' => true]);
            $this->info("Reminder sent for appointment ID: {$appointment->id}");
        }

        $this->info("Checked for appointments starting at {$targetTimeStart->format('H:i')}");
    }
}
