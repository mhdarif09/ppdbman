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
        Schema::create('applicant_parents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained()->onDelete('cascade');
            
            // Father data (all required)
            $table->string('father_name');
            $table->string('father_birth_place');
            $table->date('father_birth_date');
            $table->string('father_religion');
            $table->string('father_nationality')->default('Indonesia');
            $table->string('father_education');
            $table->string('father_occupation');
            $table->decimal('father_income', 15, 2);
            $table->text('father_address');
            $table->string('father_phone', 20);
            $table->enum('father_status', ['hidup', 'meninggal'])->default('hidup');
            
            // Mother data (all required)
            $table->string('mother_name');
            $table->string('mother_birth_place');
            $table->date('mother_birth_date');
            $table->string('mother_religion');
            $table->string('mother_nationality')->default('Indonesia');
            $table->string('mother_education');
            $table->string('mother_occupation');
            $table->decimal('mother_income', 15, 2);
            $table->text('mother_address');
            $table->string('mother_phone', 20);
            $table->enum('mother_status', ['hidup', 'meninggal'])->default('hidup');
            
            // Guardian data (all nullable - optional)
            $table->string('guardian_name')->nullable();
            $table->string('guardian_birth_place')->nullable();
            $table->date('guardian_birth_date')->nullable();
            $table->string('guardian_religion')->nullable();
            $table->string('guardian_nationality')->nullable();
            $table->string('guardian_education')->nullable();
            $table->string('guardian_occupation')->nullable();
            $table->decimal('guardian_income', 15, 2)->nullable();
            $table->text('guardian_address')->nullable();
            $table->string('guardian_phone', 20)->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_parents');
    }
};
