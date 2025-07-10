<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Category;
use App\Models\StorageLocation;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryElektronik = Category::where('name', 'Elektronik')->first();
        $categoryAlatTulis = Category::where('name', 'Alat Tulis')->first();
        $locationGudang = StorageLocation::where('name', 'Gudang Utama')->first();
        $locationServer = StorageLocation::where('name', 'Ruang Server')->first();
        $locationKantor = StorageLocation::where('name', 'Kantor Depan')->first();

        Item::create([
            'code' => 'LT-001',
            'name' => 'Laptop HP ProBook',
            'description' => 'Laptop untuk keperluan administrasi.',
            'unit' => 'pcs',
            'initial_stock' => 5,
            'current_stock' => 5,
            'price' => 7500000.00,
            'category_id' => $categoryElektronik->id,
            'storage_location_id' => $locationServer->id,
        ]);

        Item::create([
            'code' => 'PR-002',
            'name' => 'Proyektor Epson',
            'description' => 'Proyektor untuk rapat dan presentasi.',
            'unit' => 'pcs',
            'initial_stock' => 2,
            'current_stock' => 2,
            'price' => 4000000.00,
            'category_id' => $categoryElektronik->id,
            'storage_location_id' => $locationGudang->id,
        ]);

        Item::create([
            'code' => 'PN-003',
            'name' => 'Pulpen Standard',
            'description' => 'Pulpen tinta hitam.',
            'unit' => 'box',
            'initial_stock' => 100,
            'current_stock' => 100,
            'price' => 25000.00,
            'category_id' => $categoryAlatTulis->id,
            'storage_location_id' => $locationKantor->id,
        ]);
    }
}
