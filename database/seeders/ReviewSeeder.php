<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Order;
use App\Models\Psychologist;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find our dummy patient
        $patient = User::where('email', 'patient@test.com')->first();
        if (!$patient) {
            $this->command->warn('Patient patient@test.com not found. Skipping ReviewSeeder.');
            return;
        }

        $psychologists = Psychologist::all();

        if ($psychologists->isEmpty()) {
            $this->command->warn('No psychologists found. Skipping ReviewSeeder.');
            return;
        }

        // Expanded list of realistic Indonesian reviews
        $reviewsData = [
            [
                'rating' => 5,
                'review' => 'Sangat membantu dan profesional. Sesi berjalan dengan nyaman dan saya merasa didengarkan tanpa dihakimi.',
            ],
            [
                'rating' => 4,
                'review' => 'Pendekatan yang diberikan sangat praktis dan bisa langsung saya terapkan di keseharian. Terima kasih banyak!',
            ],
            [
                'rating' => 5,
                'review' => 'Luar biasa! Benar-benar membuka wawasan saya tentang bagaimana mengelola emosi dan kecemasan dengan lebih baik.',
            ],
            [
                'rating' => 5,
                'review' => 'Sesi yang sangat insightful. Psikolog sangat sabar, ramah, dan memahami kondisi saya sepenuhnya dari awal sampai akhir.',
            ],
            [
                'rating' => 4,
                'review' => 'Sesi berjalan lancar. Saya mendapatkan beberapa teknik relaksasi yang sangat berguna saat panic attack.',
            ],
            [
                'rating' => 5,
                'review' => 'Sangat direkomendasikan untuk siapa saja yang merasa overwhelmed. Sesi yang sangat melegakan hati dan pikiran.',
            ],
        ];

        $this->command->info('Creating dummy reviews for psychologists...');

        foreach ($psychologists as $psychologist) {
            // Give each psychologist 2 to 3 random reviews
            $assignedReviews = collect($reviewsData)->random(rand(2, 3));

            foreach ($assignedReviews as $idx => $reviewData) {
                // Generate a fake unique order ID
                $orderId = 'REV-' . strtoupper(Str::random(8)) . '-' . $psychologist->id . '-' . $idx;
                
                // 1. Create a successful Order
                $order = Order::create([
                    'id' => $orderId,
                    'user_id' => $patient->id,
                    'psychologist_id' => $psychologist->id,
                    'amount' => $psychologist->price_per_session,
                    'status' => 'success',
                    'service_type' => 'psikolog_klinis',
                ]);

                // 2. Create the associated completed Appointment with the rating & review
                Appointment::create([
                    'order_id' => $order->id,
                    'user_id' => $patient->id,
                    'psychologist_id' => $psychologist->id,
                    'schedule_date' => Carbon::now()->subDays(rand(1, 45))->format('Y-m-d'),
                    'schedule_time' => '10:00:00',
                    'service_type' => 'psikolog_klinis',
                    'status' => 'completed',
                    'rating' => $reviewData['rating'],
                    'review' => $reviewData['review'],
                    'is_reminded' => true,
                ]);
            }
        }

        $this->command->info('Review seeding completed successfully!');
    }
}
