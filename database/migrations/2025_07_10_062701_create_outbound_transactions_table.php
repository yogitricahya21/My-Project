<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('outbound_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade'); // Barang yang keluar
            $table->integer('quantity'); // Jumlah barang keluar
            $table->string('recipient')->nullable(); // Penerima/Departemen
            $table->string('purpose')->nullable(); // Tujuan penggunaan
            $table->text('notes')->nullable(); // Keterangan tambahan
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // User yang mencatat
            $table->timestamp('transaction_date')->useCurrent(); // Tanggal transaksi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outbound_transactions');
    }
};
