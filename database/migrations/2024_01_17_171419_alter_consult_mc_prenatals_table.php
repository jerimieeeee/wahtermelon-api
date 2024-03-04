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
        Schema::table('consult_mc_prenatals', function (Blueprint $table) {
            $table->char('presentation_code', 10)->nullable()->change();
            $table->char('location_code', 5)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consult_mc_prenatals', function (Blueprint $table) {
            $table->char('presentation_code', 10)->nullable(0)->change();
            $table->char('location_code', 5)->nullable(0)->change();
        });
    }
};
