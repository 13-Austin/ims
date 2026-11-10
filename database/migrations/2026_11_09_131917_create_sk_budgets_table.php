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
        Schema::create('sk_budgets', function (Blueprint $table) {
            $table->id();
            $table->year('fiscal_year'); // Taon ng Badyet (hal. 2026)
            $table->decimal('total_allocation', 12, 2); // Kabuuang 10% SK Fund
            $table->decimal('total_expenditure', 12, 2)->default(0); // Kabuuang nagastos
            $table->decimal('remaining_balance', 12, 2); // Natitirang pondo
            $table->text('description')->nullable(); // Paglalarawan o batayan ng pondo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sk_budgets');
    }
};