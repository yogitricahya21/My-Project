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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Kode Barang (misal: INV-001)
            $table->string('name'); // Nama Barang (misal: Laptop Lenovo)
            $table->text('description')->nullable(); // Deskripsi barang
            $table->string('unit')->default('pcs'); // Satuan (pcs, box, meter)
            $table->integer('initial_stock')->default(0); // Stok awal saat barang pertama kali dicatat
            $table->integer('current_stock')->default(0); // Stok saat ini
            $table->decimal('price', 10, 2)->nullable(); // Harga satuan (opsional)
            $table->string('image')->nullable(); // Path gambar barang (opsional)

            // Foreign keys
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->foreignId('storage_location_id')->nullable()->constrained('storage_locations')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
