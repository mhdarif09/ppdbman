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
        Schema::table('applicant_education', function (Blueprint $table) {
            $table->string('school_name')->nullable()->after('previous_school_name');
            $table->string('school_address')->nullable()->after('school_name');
            $table->string('school_type')->nullable()->after('school_address');
            $table->string('school_npsn')->nullable()->after('school_type');
            $table->string('transfer_from_grade')->nullable()->after('is_transfer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicant_education', function (Blueprint $table) {
            $table->dropColumn(['school_name', 'school_address', 'school_type', 'school_npsn', 'transfer_from_grade']);
        });
    }
};
