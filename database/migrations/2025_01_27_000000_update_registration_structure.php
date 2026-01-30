<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->json('documents_checklist')->nullable()->after('total_score');
        });

        // Update pathways
        DB::table('ppdb_pathways')->delete();
        
        $academicYear = '2024/2025'; // Fallback, normally from settings but for migration we use default
        
        // Try to get from system settings if table exists
        if (Schema::hasTable('system_settings')) {
            $setting = DB::table('system_settings')->where('key', 'academic_year_active')->first();
            if ($setting) {
                $academicYear = $setting->value;
            }
        }

        DB::table('ppdb_pathways')->insert([
            [
                'name' => 'Reguler',
                'description' => 'Jalur reguler untuk umum',
                'quota' => 100,
                'filled' => 0,
                'is_active' => true,
                'academic_year' => $academicYear,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PMPA',
                'description' => 'Penelusuran Minat dan Potensi Akademik',
                'quota' => 50,
                'filled' => 0,
                'is_active' => true,
                'academic_year' => $academicYear,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropColumn('documents_checklist');
        });
    }
};
