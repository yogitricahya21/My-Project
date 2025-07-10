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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul Kegiatan
            $table->text('description')->nullable(); // Deskripsi Kegiatan
            $table->timestamp('start_date'); // Tanggal Mulai Kegiatan
            $table->timestamp('end_date')->nullable(); // Tanggal Selesai Kegiatan (opsional)
            $table->string('location')->nullable(); // Lokasi Kegiatan
            $table->string('responsible_person')->nullable(); // Penanggung Jawab
            $table->text('attachments')->nullable(); // Path lampiran (misal: JSON array of file paths)
            $table->foreignId('activity_category_id')->nullable()->constrained('activity_categories')->onDelete('set null');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // User yang mencatat kegiatan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
