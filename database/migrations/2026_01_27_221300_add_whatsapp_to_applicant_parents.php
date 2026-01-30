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
            $table->string('father_whatsapp', 20)->nullable()->after('father_phone');
            $table->string('mother_whatsapp', 20)->nullable()->after('mother_phone');
            $table->string('guardian_whatsapp', 20)->nullable()->after('guardian_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicant_parents', function (Blueprint $table) {
            $table->dropColumn(['father_whatsapp', 'mother_whatsapp', 'guardian_whatsapp']);
        });
    }
};
