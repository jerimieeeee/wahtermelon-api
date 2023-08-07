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
        Schema::disableForeignKeyConstraints();
        Schema::table('patient_ab_pre_exposures', function (Blueprint $table) {
            $table->dropForeign(['patient_ab_id']);
            $table->dropColumn(['patient_ab_id']);

            $table->string('indication_option_remarks')->nullable()->change();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('patient_ab_pre_exposures', function (Blueprint $table) {
            $table->foreignUlid('patient_ab_id')->constrained();

            $table->string('indication_option_remarks')->change();
        });
        Schema::enableForeignKeyConstraints();
    }
};
