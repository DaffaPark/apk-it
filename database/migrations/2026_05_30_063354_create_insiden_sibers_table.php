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
        Schema::create('insiden_sibers', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_serangan', 100);
            $table->ipAddress('sumber_ip')->nullable();
            $table->text('detail')->nullable();
            $table->enum('severity', ['low', 'medium', 'high', 'critical']);
            $table->enum('status', ['terdeteksi', 'dalam_penanganan', 'selesai', 'false_positive'])->default('terdeteksi');
            $table->foreignId('tiket_id')->nullable()->constrained('tikets')->nullOnDelete();
            $table->timestamp('detected_at')->useCurrent();
            $table->timestamp('resolved_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insiden_sibers');
    }
};
