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
        Schema::create('applicant_development', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained()->onDelete('cascade');
            
            $table->year('enrollment_year'); // Required - Tahun masuk
            $table->text('scholarships')->nullable(); // Nullable - Beasiswa
            $table->year('leave_year')->nullable(); // Nullable - Tahun meninggalkan
            $table->text('leave_reason')->nullable(); // Nullable - Alasan
            $table->year('graduation_year')->nullable(); // Nullable - Tahun tamat  
            $table->date('graduation_sttb_date')->nullable(); // Nullable - Tanggal STTB
            $table->string('graduation_sttb_number')->nullable(); // Nullable - Nomor STTB
            $table->enum('after_graduation_status', ['melanjutkan', 'bekerja', 'lainnya'])->nullable(); // Nullable - Status setelah lulus
            $table->string('continued_to')->nullable(); // Nullable - Melanjutkan ke
            $table->string('working_at')->nullable(); // Nullable - Bekerja di
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_development');
    }
};
