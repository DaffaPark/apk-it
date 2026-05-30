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
        Schema::create('inventaris', function (Blueprint $table) {
            $table->id();
            $table->string('kode_qr', 50)->unique();
            $table->string('nama_perangkat', 150);
            $table->enum('jenis', ['induk', 'komponen'])->default('induk');
            $table->foreignId('induk_id')->nullable()->constrained('inventaris')->nullOnDelete();
            $table->enum('kategori', ['pc', 'monitor', 'printer', 'server', 'jaringan', 'alat_medis', 'lainnya']);
            $table->string('serial_number', 100)->nullable();
            $table->string('model', 100)->nullable();
            $table->enum('status_kondisi', ['baik', 'perlu_perhatian', 'rusak', 'disposal'])->default('baik');
            $table->string('lokasi_gedung', 100)->nullable();
            $table->string('lokasi_lantai', 50)->nullable();
            $table->string('lokasi_ruangan', 100)->nullable();
            $table->boolean('area_klinis')->default(false);
            $table->date('tanggal_pembelian')->nullable();
            $table->integer('estimasi_masa_pakai_bulan')->nullable();
            $table->date('garansi_berakhir')->nullable();
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris');
    }
};
