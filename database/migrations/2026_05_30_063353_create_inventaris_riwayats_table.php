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
        Schema::create('inventaris_riwayats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventaris_id')->constrained('inventaris')->cascadeOnDelete();
            $table->enum('jenis_aktivitas', ['perbaikan', 'penggantian_komponen', 'perawatan', 'pemeriksaan']);
            $table->text('deskripsi');
            $table->foreignId('tiket_id')->nullable()->constrained('tikets')->nullOnDelete();
            $table->decimal('biaya', 10, 2)->nullable();
            $table->foreignId('teknisi_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris_riwayats');
    }
};
