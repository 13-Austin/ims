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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_code')->unique(); // Hal. PRJ-2026-001
            $table->string('project_name');
            $table->text('description')->nullable();
            $table->decimal('allocated_budget', 12, 2); // Badyet para sa proyekto
            $table->decimal('actual_spent', 12, 2)->default(0); // Nagastos na
            $table->date('start_date');
            $table->date('target_completion_date');
            $table->enum('status', ['Planned', 'On-Going', 'Completed', 'Delayed'])->default('Planned');
            $table->string('purok_location'); // Saang purok isasagawa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};