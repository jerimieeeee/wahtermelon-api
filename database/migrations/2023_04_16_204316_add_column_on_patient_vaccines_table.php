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
        Schema::table('patient_vaccines', function (Blueprint $table) {
            $table->string('lot_no')->nullable()->index()->after('status_id');
            $table->string('batch_no')->nullable()->index()->after('lot_no');
            $table->string('facility_name')->nullable()->index()->after('batch_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_vaccines', function (Blueprint $table) {
            $table->dropColumn('lot_no');
            $table->dropColumn('batch_no');
            $table->dropColumn('facility_name');
        });
    }
};
