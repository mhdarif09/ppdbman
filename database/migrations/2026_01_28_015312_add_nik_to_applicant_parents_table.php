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
            $table->string('father_nik', 16)->nullable()->after('father_name');
            $table->string('mother_nik', 16)->nullable()->after('mother_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicant_parents', function (Blueprint $table) {
            $table->dropColumn(['father_nik', 'mother_nik']);
        });
    }
};
