<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemoTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demo_trades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('plan')->default(1);
            $table->integer('user');
            $table->string('amount');
            $table->string('activate')->nullable();
            $table->string('inv_duration')->nullable();
            $table->datetime('expire_date')->nullable();
            $table->datetime('activated_at')->nullable();
            $table->datetime('last_growth')->nullable();
            $table->string('active')->default('yes');
            $table->string('assets')->nullable();
            $table->string('symbol')->nullable();
            $table->string('leverage')->nullable();
            $table->string('type')->nullable(); // Buy/Sell
            $table->decimal('profit_earned', 20, 8)->default(0);
            $table->decimal('entry_price', 20, 8)->nullable();
            $table->decimal('current_price', 20, 8)->nullable();
            $table->string('result_type')->nullable(); // WIN/LOSE
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demo_trades');
    }
}
