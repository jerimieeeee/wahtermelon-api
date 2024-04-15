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
        Schema::table('konsulta_transmittals', function (Blueprint $table) {
            $table->year('effectivity_year')->nullable()->after('transmittal_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konsulta_transmittals', function (Blueprint $table) {
            //$table->dropIndex(['effectivity_year']);
            $table->dropColumn('effectivity_year');
        });
    }
};
