<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Activity;
use Illuminate\Database\Seeder;
use App\Models\ActivityCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $categoryRapat = ActivityCategory::where('name', 'Rapat')->first();
        $categoryPelatihan = ActivityCategory::where('name', 'Pelatihan')->first();
        $user = User::first();

        if ($categoryRapat && $user) {
            Activity::create([
                'title' => 'Rapat Koordinasi Bulanan',
                'description' => 'Rapat rutin koordinasi antar departemen untuk evaluasi kinerja bulan lalu dan perencanaan bulan depan.',
                'start_date' => now()->addDays(2)->setHour(10)->setMinute(0)->setSecond(0),
                'end_date' => now()->addDays(2)->setHour(12)->setMinute(0)->setSecond(0),
                'location' => 'Ruang Rapat Utama',
                'responsible_person' => 'Kepala Divisi Operasional',
                'attachments' => json_encode(['agenda_rapat.pdf', 'laporan_kinerja.xlsx']),
                'activity_category_id' => $categoryRapat->id,
                'user_id' => $user->id,
            ]);
        }

        if ($categoryPelatihan && $user) {
            Activity::create([
                'title' => 'Pelatihan Keterampilan Komunikasi',
                'description' => 'Pelatihan untuk meningkatkan soft skill komunikasi karyawan.',
                'start_date' => now()->addDays(7)->setHour(9)->setMinute(0)->setSecond(0),
                'end_date' => now()->addDays(7)->setHour(16)->setMinute(0)->setSecond(0),
                'location' => 'Auditorium',
                'responsible_person' => 'Tim HRD',
                'attachments' => null,
                'activity_category_id' => $categoryPelatihan->id,
                'user_id' => $user->id,
            ]);
        }
    }
}
