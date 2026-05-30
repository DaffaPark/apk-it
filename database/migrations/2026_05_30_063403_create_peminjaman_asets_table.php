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
        Schema::create('peminjaman_asets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventaris_id')->constrained('inventaris')->restrictOnDelete();
            $table->foreignId('peminjam_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nama_peminjam', 100)->nullable();
            $table->string('unit_peminjam', 100)->nullable();
            $table->text('tujuan')->nullable();
            $table->timestamp('tanggal_pinjam');
            $table->timestamp('tanggal_kembali_rencana');
            $table->timestamp('tanggal_kembali_aktual')->nullable();
            $table->enum('status', ['dipinjam', 'dikembalikan', 'terlambat'])->default('dipinjam');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_asets');
    }
};
