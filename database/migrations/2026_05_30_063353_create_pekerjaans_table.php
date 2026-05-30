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
        Schema::create('pekerjaans', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 200);
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['to_do', 'in_progress', 'done'])->default('to_do');
            $table->enum('prioritas', ['low', 'medium', 'high', 'critical'])->nullable();
            $table->foreignId('assignee_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('tiket_id')->nullable()->constrained('tikets')->nullOnDelete();
            $table->timestamp('deadline')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pekerjaans');
    }
};
