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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('borrower_name'); // Nama Peminjam
            $table->string('borrower_department')->nullable(); // Departemen Peminjam (opsional)
            $table->timestamp('loan_date')->useCurrent(); // Tanggal Peminjaman
            $table->timestamp('due_date')->nullable(); // Tanggal Jatuh Tempo Pengembalian
            $table->timestamp('return_date')->nullable(); // Tanggal Pengembalian Aktual
            $table->enum('status', ['pending', 'borrowed', 'returned', 'overdue'])->default('borrowed'); // Status Peminjaman
            $table->text('notes')->nullable(); // Keterangan tambahan
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // User yang mencatat peminjaman
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
