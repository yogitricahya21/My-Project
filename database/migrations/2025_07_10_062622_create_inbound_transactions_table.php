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
        Schema::create('inbound_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade'); // Barang yang masuk
            $table->integer('quantity'); // Jumlah barang masuk
            $table->string('source')->nullable(); // Sumber/Supplier barang
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
        Schema::dropIfExists('inbound_transactions');
    }
};
