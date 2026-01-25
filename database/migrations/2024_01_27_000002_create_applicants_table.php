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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ppdb_pathway_id')->nullable()->constrained()->onDelete('set null');
            
            // Data Pribadi
            $table->string('nisn', 10)->unique()->comment('Nomor Induk Siswa Nasional');
            $table->string('full_name');
            $table->date('birth_date');
            $table->string('birth_place');
            $table->enum('gender', ['L', 'P'])->comment('L=Laki-laki, P=Perempuan');
            $table->text('address');
            $table->string('phone', 20);
            
            // Data Orang Tua
            $table->string('parent_name')->nullable();
            $table->string('parent_phone', 20)->nullable();
            
            // Status & Verifikasi
            $table->string('registration_number', 20)->unique()->comment('Nomor pendaftaran unik');
            $table->enum('status', ['pending', 'verified', 'accepted', 'rejected'])->default('pending');
            $table->string('academic_year', 20);
            
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('verification_notes')->nullable();
            $table->text('rejection_reason')->nullable();
            
            // Scoring (untuk seleksi)
            $table->decimal('total_score', 5, 2)->nullable()->comment('Nilai total untuk ranking');
            
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'academic_year']);
            $table->index('ppdb_pathway_id');
            $table->index('registration_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
