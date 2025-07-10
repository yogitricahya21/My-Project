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
        Schema::create('loan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained('loans')->onDelete('cascade'); // ID Peminjaman
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade'); // ID Barang yang dipinjam
            $table->integer('quantity'); // Kuantitas barang yang dipinjam
            $table->text('condition_on_loan')->nullable(); // Kondisi saat dipinjam
            $table->text('condition_on_return')->nullable(); // Kondisi saat dikembalikan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_items');
    }
};
