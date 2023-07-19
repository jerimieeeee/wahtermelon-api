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
        Schema::table('eclaims_caserate_lists', function (Blueprint $table) {
            $table->string('discharge_dx')->nullable()->after('description');
            $table->string('icd10_code', 50)->nullable()->after('discharge_dx');

            $table->foreign('icd10_code')->references('icd10_code')->on('lib_icd10s');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('eclaims_caserate_lists', function (Blueprint $table) {
            $table->dropColumn('discharge_dx');
            $table->dropForeign(['icd10_code']);
            $table->dropColumn('icd10_code');
        });
        Schema::enableForeignKeyConstraints();
    }
};
