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
        Schema::table('patient_gbv_interview_perpetrators', function (Blueprint $table) {
            $table->boolean('lgbtq_flag')->after('gender')->nullable();
            $table->string('perpetrator_current_address')->after('perpetrator_address')->nullable();
            $table->unsignedBigInteger('education_code')->after('occupation_code')->nullable();

            $table->foreign('education_code')->references('code')->on('lib_education');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('patient_gbv_interview_perpetrators', function (Blueprint $table) {
            $table->dropColumn('lgbtq_flag');
            $table->dropColumn('perpetrator_current_address');
            $table->dropForeign(['education_code']);
            $table->dropColumn('education_code');
        });
        Schema::enableForeignKeyConstraints();
    }
};
