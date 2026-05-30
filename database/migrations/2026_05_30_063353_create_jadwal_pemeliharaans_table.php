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
        Schema::create('jadwal_pemeliharaans', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 200);
            $table->enum('jenis', ['rutin', 'sekali'])->default('rutin');
            $table->integer('frekuensi_hari')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->foreignId('inventaris_id')->nullable()->constrained('inventaris')->nullOnDelete();
            $table->boolean('reminder_h3')->default(true);
            $table->json('checklist_json')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_pemeliharaans');
    }
};
