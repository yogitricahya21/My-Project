<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['name' => 'Elektronik', 'description' => 'Barang-barang elektronik seperti laptop, proyektor.']);
        Category::create(['name' => 'Alat Tulis', 'description' => 'Pulpen, kertas, spidol, dll.']);
        Category::create(['name' => 'Perabot', 'description' => 'Meja, kursi, lemari.']);
        Category::create(['name' => 'Kebersihan', 'description' => 'Peralatan dan bahan kebersihan.']);
    }
}
