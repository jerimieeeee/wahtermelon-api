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
        Schema::table('patient_gbv_interview_summaries', function (Blueprint $table) {
            $table->char('alleged_perpetrator', 26)->change();
            $table->foreign('alleged_perpetrator')->references('id')->on('patient_gbv_interview_perpetrators');

            $table->char('summary_type',2)->after('intake_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('patient_gbv_interview_summaries', function (Blueprint $table) {
            $table->dropForeign(['alleged_perpetrator']);
            $table->string('alleged_perpetrator')->change();

            $table->dropColumn('summary_type')->after('intake_id')->nullable();
        });
        Schema::enableForeignKeyConstraints();
    }
};
