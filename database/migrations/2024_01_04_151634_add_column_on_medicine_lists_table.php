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
        Schema::table('medicine_lists', function (Blueprint $table) {
            $table->bigInteger('medicine_route')->after('quantity_preparation')->unsigned();

            $table->foreign('medicine_route')->references('code')->on('lib_medicine_routes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicine_lists', function (Blueprint $table) {
            $table->dropColumn('medicine_route');
        });
    }
};
