<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lead_import_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');
            $table->string('filename', 255);
            $table->string('file_path', 500)->nullable();
            $table->enum('status', ['processing', 'completed', 'failed', 'cancelled'])->default('processing');
            $table->integer('total_rows')->default(0);
            $table->integer('processed_rows')->default(0);
            $table->integer('success_count')->default(0);
            $table->integer('error_count')->default(0);
            $table->integer('warning_count')->default(0);
            $table->json('errors')->nullable();
            $table->json('warnings')->nullable();
            $table->json('import_settings')->nullable();
            $table->decimal('progress_percentage', 5, 2)->default(0);
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->text('failure_reason')->nullable();
            $table->timestamps();

            $table->index(['admin_id', 'created_at'], 'idx_import_admin_created');
            $table->index(['status'], 'idx_import_status');
            $table->index(['started_at'], 'idx_import_started');
        });

        Schema::create('lead_export_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');
            $table->string('filename', 255);
            $table->string('file_path', 500)->nullable();
            $table->enum('format', ['xlsx', 'csv', 'pdf'])->default('xlsx');
            $table->enum('status', ['processing', 'completed', 'failed', 'expired'])->default('processing');
            $table->integer('record_count')->default(0);
            $table->json('filters_applied')->nullable();
            $table->json('columns_exported')->nullable();
            $table->json('export_settings')->nullable();
            $table->decimal('file_size_kb', 10, 2)->nullable();
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->text('failure_reason')->nullable();
            $table->timestamps();

            $table->index(['admin_id', 'created_at'], 'idx_export_admin_created');
            $table->index(['status'], 'idx_export_status');
            $table->index(['started_at'], 'idx_export_started');
            $table->index(['expires_at'], 'idx_export_expires');
        });
    }

    public function down()
    {
        Schema::dropIfExists('lead_export_logs');
        Schema::dropIfExists('lead_import_logs');
    }
};