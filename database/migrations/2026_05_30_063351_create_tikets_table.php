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
        Schema::create('tikets', function (Blueprint $table) {
            $table->id();
            $table->string('kode_unik', 64)->unique();
            $table->foreignId('pelapor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('pelapor_nama', 100)->nullable();
            $table->string('pelapor_unit', 100)->nullable();
            $table->text('keluhan');
            $table->text('penyebab')->nullable();
            $table->text('solusi')->nullable();
            $table->enum('prioritas', ['low', 'medium', 'high', 'critical']);
            $table->enum('kategori', ['hardware', 'software', 'jaringan', 'akun_password', 'simrs', 'alat_medis', 'lainnya']);
            $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])->default('open');
            $table->foreignId('teknisi_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('parent_tiket_id')->nullable()->constrained('tikets')->nullOnDelete();
            $table->timestamp('sla_deadline')->nullable();
            $table->timestamp('eskalasi_terakhir')->nullable();
            $table->tinyInteger('feedback_rating')->nullable();
            $table->text('feedback_catatan')->nullable();
            $table->timestamps();
            $table->timestamp('resolved_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tikets');
    }
};
