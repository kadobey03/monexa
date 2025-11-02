<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceToInstrumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('instruments', function (Blueprint $table) {
            // Check if price column doesn't exist before adding it
            if (!Schema::hasColumn('instruments', 'price')) {
                $table->decimal('price', 20, 8)->nullable();
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
        Schema::table('instruments', function (Blueprint $table) {
            //
        });
    }
}
