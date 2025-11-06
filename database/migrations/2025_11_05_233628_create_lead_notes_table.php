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
        Schema::create("lead_notes", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("admin_id");
            $table->string("note_title");
            $table->text("note_content");
            $table->string("note_category")->nullable();
            $table->string("note_color")->default("blue");
            $table->boolean("is_pinned")->default(false);
            $table->boolean("is_private")->default(false);
            $table->datetime("reminder_date")->nullable();
            $table->json("tags")->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("admin_id")->references("id")->on("admins")->onDelete("cascade");

            // Indexes for better performance
            $table->index(["user_id", "created_at"]);
            $table->index(["admin_id", "created_at"]);
            $table->index("is_pinned");
            $table->index("reminder_date");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("lead_notes");
    }
};
