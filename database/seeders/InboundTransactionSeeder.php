<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\InboundTransaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InboundTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $itemLaptop = Item::where('code', 'LT-001')->first();
        $itemPulpen = Item::where('code', 'PN-003')->first();
        $user = User::first(); // Ambil user pertama yang ada (dari Breeze)

        if ($itemLaptop && $user) {
            InboundTransaction::create([
                'item_id' => $itemLaptop->id,
                'quantity' => 3,
                'source' => 'PT. Distributor Elektronik',
                'notes' => 'Pembelian tambahan laptop untuk karyawan baru.',
                'user_id' => $user->id,
                'transaction_date' => now()->subDays(10),
            ]);
            // Update current_stock di Item
            $itemLaptop->current_stock += 3;
            $itemLaptop->save();
        }

        if ($itemPulpen && $user) {
            InboundTransaction::create([
                'item_id' => $itemPulpen->id,
                'quantity' => 50,
                'source' => 'Toko Alat Tulis Jaya',
                'notes' => 'Restock pulpen bulanan.',
                'user_id' => $user->id,
                'transaction_date' => now()->subDays(5),
            ]);
            // Update current_stock di Item
            $itemPulpen->current_stock += 50;
            $itemPulpen->save();
        }
    }
}
