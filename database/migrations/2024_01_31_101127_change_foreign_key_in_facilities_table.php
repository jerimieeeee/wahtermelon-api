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
        \App\Models\V1\PSGC\Facility::query()->update(['region_code' => null, 'province_code' => null, 'municipality_code' => null, 'barangay_code' => null]);
        Schema::table('facilities', function (Blueprint $table) {
            // Drop the existing foreign key
            $table->dropForeign(['region_code']);
            $table->dropForeign(['province_code']);
            $table->dropForeign(['municipality_code']);
            $table->dropForeign(['barangay_code']);

            // Add a new foreign key with the desired changes
            $table->foreign('region_code')->references('psgc_10_digit_code')->on('regions');
            $table->foreign('province_code')->references('psgc_10_digit_code')->on('provinces');
            $table->foreign('municipality_code')->references('psgc_10_digit_code')->on('municipalities');
            $table->foreign('barangay_code')->references('psgc_10_digit_code')->on('barangays');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            // Drop the existing foreign key
            $table->dropForeign(['region_code']);
            $table->dropForeign(['province_code']);
            $table->dropForeign(['municipality_code']);
            $table->dropForeign(['barangay_code']);

            $table->foreign('region_code')->references('code')->on('regions');
            $table->foreign('province_code')->references('code')->on('provinces');
            $table->foreign('municipality_code')->references('code')->on('municipalities');
            $table->foreign('barangay_code')->references('code')->on('barangays');
        });
    }
};
