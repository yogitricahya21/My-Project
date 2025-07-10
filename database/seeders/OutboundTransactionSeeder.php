<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\OutboundTransaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OutboundTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $itemLaptop = Item::where('code', 'LT-001')->first();
        $itemProyektor = Item::where('code', 'PR-002')->first();
        $user = User::first();

        if ($itemLaptop && $user) {
            OutboundTransaction::create([
                'item_id' => $itemLaptop->id,
                'quantity' => 1,
                'recipient' => 'Departemen Keuangan',
                'purpose' => 'Pengadaan laptop untuk karyawan baru.',
                'notes' => 'Diserahkan kepada Bpk. Andi.',
                'user_id' => $user->id,
                'transaction_date' => now()->subDays(8),
            ]);
            // Update current_stock di Item
            $itemLaptop->current_stock -= 1;
            $itemLaptop->save();
        }

        if ($itemProyektor && $user) {
            OutboundTransaction::create([
                'item_id' => $itemProyektor->id,
                'quantity' => 1,
                'recipient' => 'Ruang Rapat A',
                'purpose' => 'Pemasangan proyektor baru.',
                'notes' => 'Dipasang oleh tim teknisi.',
                'user_id' => $user->id,
                'transaction_date' => now()->subDays(3),
            ]);
            // Update current_stock di Item
            $itemProyektor->current_stock -= 1;
            $itemProyektor->save();
        }
    }
}
