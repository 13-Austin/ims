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
        Schema::table('projects', function (Blueprint $table) {
            // Sinisigurong tama ang decimal format ng actual spent at nagdaragdag tayo ng funded_by para sa monitoring
            $table->decimal('actual_spent', 12, 2)->default(0)->change();
            $table->string('funded_by')->nullable()->after('allocated_budget');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Ibalik sa dati sakaling i-rollback ang migration
            $table->dropColumn('funded_by');
        });
    }
};