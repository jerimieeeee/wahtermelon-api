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
        Schema::table('patient_death_records', function (Blueprint $table) {
            $table->dropForeign(['antecedent_cause']);
            $table->dropForeign(['underlying_cause']);
            $table->dropColumn('antecedent_cause');
            $table->dropColumn('underlying_cause');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_death_records', function (Blueprint $table) {
            $table->string('antecedent_cause', 50)->constrained()->nullable();
            $table->string('underlying_cause', 50)->constrained()->nullable();
            $table->foreign('antecedent_cause')->references('icd10_code')->on('lib_icd10s');
            $table->foreign('underlying_cause')->references('icd10_code')->on('lib_icd10s');
        });
    }
};
