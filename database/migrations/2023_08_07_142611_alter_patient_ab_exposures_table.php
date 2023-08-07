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
        Schema::table('patient_ab_exposures', function (Blueprint $table) {
            $table->string('tandok_name')->after('pep_flag')->nullable();
            $table->string('tandok_addresss')->after('pep_flag')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_ab_exposures', function (Blueprint $table) {
            $table->dropColumn('tandok_name');
            $table->dropColumn('tandok_addresss');
        });
    }
};
