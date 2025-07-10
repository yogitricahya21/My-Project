<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder yang Anda buat
        $this->call([
            CategorySeeder::class,
            StorageLocationSeeder::class,
            ItemSeeder::class,
            ActivityCategorySeeder::class,
            ActivitySeeder::class,
            // Penting: Inbound dan Outbound harus setelah Item,
            // Loan harus setelah Item dan User
            InboundTransactionSeeder::class,
            OutboundTransactionSeeder::class,
            LoanSeeder::class,
        ]);
    }
}
