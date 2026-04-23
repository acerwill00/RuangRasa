<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Psychologist;
use Illuminate\Support\Str;

class PsychologistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $psychologists = [
            [
                'name' => 'Dr. Rina Amelia, S.Psi., M.Psi.',
                'slug' => Str::slug('Dr. Rina Amelia, S.Psi., M.Psi.'),
                'bio' => 'Berpengalaman lebih dari 10 tahun menangani masalah kecemasan dan depresi.',
                'photo_url' => 'https://i.pravatar.cc/300?img=1',
                'specialization' => 'Kecemasan, Depresi, Stress Management',
                'price_per_session' => 150000,
            ],
            [
                'name' => 'Budi Santoso, M.Psi., Psikolog',
                'slug' => Str::slug('Budi Santoso, M.Psi., Psikolog'),
                'bio' => 'Fokus pada masalah pernikahan, keluarga, dan trauma masa kecil.',
                'photo_url' => 'https://i.pravatar.cc/300?img=11',
                'specialization' => 'Pernikahan, Keluarga, Trauma',
                'price_per_session' => 200000,
            ],
            [
                'name' => 'Siti Nurhaliza, M.Psi.',
                'slug' => Str::slug('Siti Nurhaliza, M.Psi.'),
                'bio' => 'Membantu remaja dan dewasa muda dalam menghadapi krisis identitas dan masalah karir.',
                'photo_url' => 'https://i.pravatar.cc/300?img=5',
                'specialization' => 'Remaja, Krisis Identitas, Karir',
                'price_per_session' => 120000,
            ],
            [
                'name' => 'Dr. Andi Pratama, Sp.KJ',
                'slug' => Str::slug('Dr. Andi Pratama, Sp.KJ'),
                'bio' => 'Psikiater dengan pengalaman luas menangani gangguan mood dan ADHD.',
                'photo_url' => 'https://i.pravatar.cc/300?img=8',
                'specialization' => 'ADHD, Gangguan Mood',
                'price_per_session' => 250000,
            ],
        ];

        foreach ($psychologists as $data) {
            Psychologist::firstOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}
