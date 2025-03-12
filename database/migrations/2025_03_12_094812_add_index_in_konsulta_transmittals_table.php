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
            $table->index('transmittal_number');
            $table->index('tranche');
            $table->index('effectivity_year');
            $table->index('xml_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konsulta_transmittals', function (Blueprint $table) {
            $table->dropIndex(['transmittal_number']);
            $table->dropIndex(['tranche']);
            $table->dropIndex(['effectivity_year']);
            $table->dropIndex(['xml_status']);
        });
    }
};
