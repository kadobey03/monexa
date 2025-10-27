<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_table_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');
            $table->string('table_name', 100)->default('leads');
            $table->json('visible_columns')->nullable();
            $table->json('column_widths')->nullable();
            $table->json('column_order')->nullable();
            $table->json('filters')->nullable();
            $table->integer('page_size')->default(25);
            $table->string('sort_column', 100)->default('created_at');
            $table->enum('sort_direction', ['asc', 'desc'])->default('desc');
            $table->timestamps();

            $table->unique(['admin_id', 'table_name']);
            $table->index(['admin_id', 'table_name']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_table_settings');
    }
};