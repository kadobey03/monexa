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
        Schema::create('admin_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->nullable(); // Actionu yapan admin
            $table->string('admin_name')->nullable(); // Admin adı (admin silinirse diye)
            $table->string('admin_email')->nullable(); // Admin emaili (admin silinirse diye)
            
            // Action details
            $table->string('action'); // create, update, delete, login, logout, assign, etc.
            $table->string('entity_type')->nullable(); // user, admin, role, lead, etc.
            $table->unsignedBigInteger('entity_id')->nullable(); // Affected record ID
            $table->string('entity_name')->nullable(); // Entity name/title
            
            // Request details
            $table->string('method')->nullable(); // GET, POST, PUT, DELETE
            $table->string('url')->nullable(); // Request URL
            $table->string('route')->nullable(); // Route name
            $table->json('request_data')->nullable(); // Request parameters
            $table->json('old_values')->nullable(); // Old values before change
            $table->json('new_values')->nullable(); // New values after change
            
            // System and context info
            $table->string('ip_address')->nullable(); // IP address
            $table->text('user_agent')->nullable(); // User agent
            $table->string('session_id')->nullable(); // Session ID
            $table->json('headers')->nullable(); // Request headers
            
            // Business context
            $table->string('category')->nullable(); // user_management, lead_management, system, etc.
            $table->string('severity')->default('info'); // info, warning, error, critical
            $table->string('status')->default('success'); // success, failed, partial
            $table->text('description')->nullable(); // Human readable description
            $table->text('reason')->nullable(); // Why was this action performed
            
            // Impact tracking
            $table->json('affected_entities')->nullable(); // Other affected records
            $table->integer('affected_count')->default(0); // Number of affected records
            $table->boolean('is_bulk_operation')->default(false); // Was this a bulk operation
            $table->string('operation_id')->nullable(); // Group related operations
            
            // Performance metrics
            $table->integer('execution_time_ms')->nullable(); // How long did it take
            $table->integer('memory_usage_mb')->nullable(); // Memory usage
            $table->json('performance_metrics')->nullable(); // Additional metrics
            
            // Compliance and security
            $table->boolean('is_sensitive')->default(false); // Contains sensitive data
            $table->boolean('requires_approval')->default(false); // Required approval
            $table->unsignedBigInteger('approved_by')->nullable(); // Who approved
            $table->timestamp('approved_at')->nullable(); // When approved
            $table->string('compliance_status')->nullable(); // compliant, non_compliant, pending
            
            // Geographic and device info
            $table->string('country')->nullable(); // Country from IP
            $table->string('city')->nullable(); // City from IP
            $table->string('device_type')->nullable(); // desktop, mobile, tablet
            $table->string('browser')->nullable(); // Browser info
            $table->string('os')->nullable(); // Operating system
            
            // Additional metadata
            $table->json('tags')->nullable(); // Tags for categorization
            $table->json('metadata')->nullable(); // Additional metadata
            $table->string('reference_id')->nullable(); // Reference to external system
            $table->text('notes')->nullable(); // Additional notes
            
            // Timestamps
            $table->timestamp('occurred_at')->default(now()); // When action occurred
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('approved_by')->references('id')->on('admins')->onDelete('set null');
            
            // Indexes for better performance
            $table->index('admin_id');
            $table->index('action');
            $table->index('entity_type');
            $table->index('entity_id');
            $table->index(['entity_type', 'entity_id']);
            $table->index('occurred_at');
            $table->index('created_at');
            $table->index('category');
            $table->index('severity');
            $table->index('status');
            $table->index('ip_address');
            $table->index('session_id');
            $table->index('operation_id');
            $table->index(['admin_id', 'occurred_at']);
            $table->index(['action', 'entity_type']);
            $table->index(['category', 'severity']);
            $table->index(['is_sensitive', 'occurred_at']);
            $table->index(['is_bulk_operation', 'occurred_at']);
            $table->index(['compliance_status', 'occurred_at']);
            
            // Composite indexes for common queries
            $table->index(['admin_id', 'action', 'occurred_at'], 'admin_action_time_idx');
            $table->index(['entity_type', 'action', 'occurred_at'], 'entity_action_time_idx');
            $table->index(['category', 'status', 'occurred_at'], 'category_status_time_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_audit_logs');
    }
};