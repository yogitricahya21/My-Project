<?php

namespace Database\Seeders;

use App\Models\StorageLocation;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StorageLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StorageLocation::create(['name' => 'Gudang Utama', 'description' => 'Gudang penyimpanan barang utama.']);
        StorageLocation::create(['name' => 'Ruang Server', 'description' => 'Lokasi penyimpanan peralatan IT.']);
        StorageLocation::create(['name' => 'Kantor Depan', 'description' => 'Penyimpanan alat tulis dan kebutuhan kantor.']);
    }
}
