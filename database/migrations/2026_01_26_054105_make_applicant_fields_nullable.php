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
            $table->date('birth_date')->nullable()->change();
            $table->string('birth_place')->nullable()->change();
            $table->enum('gender', ['L', 'P'])->nullable()->comment('L=Laki-laki, P=Perempuan')->change();
            $table->text('address')->nullable()->change();
            $table->string('phone', 20)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->date('birth_date')->nullable(false)->change();
            $table->string('birth_place')->nullable(false)->change();
            $table->enum('gender', ['L', 'P'])->nullable(false)->comment('L=Laki-laki, P=Perempuan')->change();
            $table->text('address')->nullable(false)->change();
            $table->string('phone', 20)->nullable(false)->change();
        });
    }
};
