<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->string('control_number')->nullable()->unique()->after('id'); // e.g., BRGY-2026-0001
            $table->string('dry_seal_number')->nullable()->after('status');
            
            // Signatory & Approval Tracking
            $table->string('signatory_name')->nullable()->after('dry_seal_number'); // e.g., Hon. Aloha Cua-Bautista
            $table->string('signatory_title')->nullable()->after('signatory_name'); // e.g., Punong Barangay / Kagawad on Duty
            
            // User IDs for Traceability
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete()->after('signatory_title');
            $table->foreignId('issued_by')->nullable()->constrained('users')->nullOnDelete()->after('approved_by');
            $table->timestamp('approved_at')->nullable()->after('issued_by');
            $table->timestamp('issued_at')->nullable()->after('approved_at');
        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropForeign(['issued_by']);
            $table->dropColumn([
                'control_number', 'dry_seal_number', 'signatory_name', 
                'signatory_title', 'approved_by', 'issued_by', 
                'approved_at', 'issued_at'
            ]);
        });
    }
};