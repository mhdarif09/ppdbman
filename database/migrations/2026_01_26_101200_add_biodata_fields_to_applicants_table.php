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
        Schema::table('applicants', function (Blueprint $table) {
            // Personal Info
            $table->string('nickname')->nullable()->after('full_name');
            $table->string('nis', 20)->nullable()->after('nisn');
            $table->string('religion')->nullable();
            $table->string('nationality')->default('Indonesia');
            $table->string('language')->nullable();
            
            // Family Info
            $table->integer('child_order')->nullable();
            $table->integer('siblings_count')->nullable();
            $table->integer('half_siblings_count')->nullable();
            $table->integer('adopted_siblings_count')->nullable();
            $table->enum('child_status', ['lengkap', 'yatim', 'piatu', 'yatim_piatu'])->nullable();
            
            // Contact & Address
            $table->text('current_address')->nullable();
            $table->string('whatsapp_number', 20)->nullable();
            
            // Health Info
            $table->enum('blood_type', ['A', 'B', 'AB', 'O'])->nullable();
            $table->json('diseases')->nullable();
            $table->text('allergies')->nullable();
            $table->text('physical_defects')->nullable();
            $table->integer('height')->nullable(); // cm
            $table->integer('weight')->nullable(); // kg
            
            // Biodata Status
            $table->timestamp('biodata_completed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropColumn([
                'nickname', 'nis', 'religion', 'nationality', 'language',
                'child_order', 'siblings_count', 'half_siblings_count', 'adopted_siblings_count', 'child_status',
                'current_address', 'whatsapp_number',
                'blood_type', 'diseases', 'allergies', 'physical_defects', 'height', 'weight',
                'biodata_completed_at'
            ]);
        });
    }
};
