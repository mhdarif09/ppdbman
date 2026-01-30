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
        Schema::create('applicant_hobbies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained()->onDelete('cascade');
            
            // All hobbies are nullable
            $table->text('arts')->nullable(); // Kesenian
            $table->text('sports')->nullable(); // Pendidikan jasmani/olahraga
            $table->text('organization')->nullable(); // Organisasi
            $table->text('other')->nullable(); // Lain-lain
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_hobbies');
    }
};
