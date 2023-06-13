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
        Schema::table('patient_gbv_intakes', function (Blueprint $table) {
            $table->boolean('consent_flag')->after('patient_gbv_id')->default(0);
            $table->foreignId('consent_relation_to_child_id')->after('consent_flag')->on('lib_gbv_child_relations')->nullable();
            $table->string('consent_guardian_name')->after('consent_relation_to_child_id')->nullable();
            $table->date('consent_date')->after('consent_guardian_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('patient_gbv_intakes', function (Blueprint $table) {
            $table->dropColumn('consent_flag');
            $table->dropColumn('consent_relation_to_child_id');
            $table->dropColumn('consent_guardian_name');
            $table->dropColumn('consent_date');
        });
        Schema::enableForeignKeyConstraints();
    }
};
