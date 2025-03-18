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
        Schema::table('facilities', function (Blueprint $table) {
            $table->index('code');
//            $table->index('region_code');
            $table->index('province_code');
            $table->index('municipality_code');
            $table->index('barangay_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            $table->dropIndex(['code']);
//            $table->dropIndex(['region_code']);
            $table->dropIndex(['province_code']);
            $table->dropIndex(['municipality_code']);
            $table->dropIndex(['barangay_code']);
        });
    }
};
