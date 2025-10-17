<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Check if columns don't exist before adding them
            if (!Schema::hasColumn('notifications', 'admin_id')) {
                $table->integer('admin_id')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('notifications', 'title')) {
                $table->string('title')->nullable()->after('admin_id');
            }
            if (!Schema::hasColumn('notifications', 'type')) {
                $table->string('type')->default('info')->after('message');
            }
            if (!Schema::hasColumn('notifications', 'is_read')) {
                $table->boolean('is_read')->default(false)->after('type');
            }
            if (!Schema::hasColumn('notifications', 'source_id')) {
                $table->integer('source_id')->nullable()->after('is_read');
            }
            if (!Schema::hasColumn('notifications', 'source_type')) {
                $table->string('source_type')->nullable()->after('source_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn('admin_id');
            $table->dropColumn('title');
            $table->dropColumn('type');
            $table->dropColumn('is_read');
            $table->dropColumn('source_id');
            $table->dropColumn('source_type');
        });
    }
}
