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
        Schema::table('applicant_parents', function (Blueprint $table) {
            $table->string('father_job')->nullable()->after('father_occupation');
            $table->string('mother_job')->nullable()->after('mother_occupation');
            $table->string('guardian_job')->nullable()->after('guardian_occupation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicant_parents', function (Blueprint $table) {
            $table->dropColumn(['father_job', 'mother_job', 'guardian_job']);
        });
    }
};
