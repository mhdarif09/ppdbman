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
        Schema::create('applicant_education', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained()->onDelete('cascade');
            
            // Education history
            $table->string('previous_school_name'); // Required - Asal sekolah
            $table->string('sttb_number')->nullable(); // Nullable - Nomor STTB
            $table->date('sttb_date')->nullable(); // Nullable - Tanggal STTB
            $table->integer('study_duration'); // Required - Lama belajar (tahun)
            $table->boolean('is_transfer')->default(false); // Required - Status pindahan
            
            // Transfer info (nullable if not transfer)
            $table->string('transfer_from_school')->nullable(); // Asal sekolah sebelumnya
            $table->string('transfer_class')->nullable(); // Kelas/program saat diterima
            $table->date('transfer_date')->nullable(); // Tanggal diterima
            $table->string('transfer_program')->nullable(); // Program
            $table->text('transfer_reason')->nullable(); // Alasan pindah
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_education');
    }
};
