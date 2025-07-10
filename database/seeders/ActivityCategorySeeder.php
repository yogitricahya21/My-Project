<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ActivityCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ActivityCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         ActivityCategory::create(['name' => 'Rapat', 'description' => 'Kegiatan rapat internal dan eksternal.']);
        ActivityCategory::create(['name' => 'Pelatihan', 'description' => 'Kegiatan pengembangan karyawan.']);
        ActivityCategory::create(['name' => 'Proyek', 'description' => 'Kegiatan terkait proyek tertentu.']);
        ActivityCategory::create(['name' => 'Acara', 'description' => 'Event atau acara organisasi.']);
    }
}
