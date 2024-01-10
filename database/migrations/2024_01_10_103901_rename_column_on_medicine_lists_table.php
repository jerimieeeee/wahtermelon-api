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
            $table->renameColumn('medicine_route', 'medicine_route_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicine_lists', function (Blueprint $table) {
            $table->renameColumn('medicine_route_code', 'medicine_route');
        });
    }
};
