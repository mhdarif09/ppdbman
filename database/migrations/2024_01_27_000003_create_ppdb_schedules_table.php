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
        Schema::create('ppdb_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Pendaftaran, Verifikasi, Pengumuman');
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('academic_year', 20);
            $table->timestamps();

            $table->index('academic_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppdb_schedules');
    }
};
