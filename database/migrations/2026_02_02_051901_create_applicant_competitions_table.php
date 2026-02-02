<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applicant_competitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained('applicants')->onDelete('cascade');
            $table->string('competition_name');
            $table->year('year');
            $table->enum('level', ['kecamatan', 'kota', 'provinsi', 'nasional']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applicant_competitions');
    }
};
