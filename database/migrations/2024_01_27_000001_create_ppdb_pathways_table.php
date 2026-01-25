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
        Schema::create('ppdb_pathways', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Nama jalur: Zonasi, Prestasi, Afirmasi, dll');
            $table->text('description')->nullable();
            $table->integer('quota')->default(0)->comment('Kuota jalur');
            $table->integer('filled')->default(0)->comment('Jumlah sudah terisi');
            $table->boolean('is_active')->default(true);
            $table->string('academic_year', 20)->comment('Tahun ajaran');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['academic_year', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppdb_pathways');
    }
};
