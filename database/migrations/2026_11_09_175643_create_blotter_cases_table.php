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
        Schema::create('blotter_cases', function (Blueprint $table) {
            $table->id();
            $table->string('case_number')->unique(); // Halimbawa: BLT-2026-001
            $table->string('complainant_name');      // Nagrereklamo
            $table->string('respondent_name');      // Inirereklamo
            $table->string('incident_location');    // Purok / Lugar ng pinangyarihan
            $table->dateTime('incident_date');      // Petsa at oras ng insidente
            $table->text('complaint_details');      // Salaysay ng reklamo
            $table->string('status')->default('Pending'); // Pending, Summoned, Settled, Dismissed, Filed in Court
            $table->date('hearing_date')->nullable();     // Petsa ng Pagpupulong / Hearing
            $table->text('agreement_details')->nullable(); // Kasunduan (Amicable Settlement)
            $table->foreignId('recorded_by')->constrained('users'); // Sinong staff/admin nag-encode
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blotter_cases');
    }
};