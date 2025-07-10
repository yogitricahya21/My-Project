<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Loan;
use App\Models\User;
use App\Models\LoanItem;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $itemLaptop = Item::where('code', 'LT-001')->first();
        $itemProyektor = Item::where('code', 'PR-002')->first();
        $user = User::first();

        if ($itemLaptop && $itemProyektor && $user) {
            // Peminjaman 1
            $loan1 = Loan::create([
                'borrower_name' => 'Budi Santoso',
                'borrower_department' => 'Marketing',
                'loan_date' => now()->subDays(7),
                'due_date' => now()->subDays(2), // Sudah jatuh tempo
                'status' => 'overdue',
                'notes' => 'Untuk presentasi di luar kota.',
                'user_id' => $user->id,
            ]);
            LoanItem::create([
                'loan_id' => $loan1->id,
                'item_id' => $itemLaptop->id,
                'quantity' => 1,
                'condition_on_loan' => 'Baik',
            ]);
            // Kurangi stok
            $itemLaptop->current_stock -= 1;
            $itemLaptop->save();


            // Peminjaman 2
            $loan2 = Loan::create([
                'borrower_name' => 'Siti Aminah',
                'borrower_department' => 'HRD',
                'loan_date' => now()->subDays(3),
                'due_date' => now()->addDays(5), // Masih aktif
                'status' => 'borrowed',
                'notes' => 'Untuk pelatihan internal.',
                'user_id' => $user->id,
            ]);
            LoanItem::create([
                'loan_id' => $loan2->id,
                'item_id' => $itemProyektor->id,
                'quantity' => 1,
                'condition_on_loan' => 'Baik',
            ]);
            // Kurangi stok
            $itemProyektor->current_stock -= 1;
            $itemProyektor->save();
        }
    }
}
