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
        Schema::create('lib_asrh_algorithm_pivot', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignId('lib_rapid_questionnaire_id')->constrained('lib_rapid_questionnaires')->cascadeOnDelete();
            $table->char('lib_asrh_algorithm_code', 10)->index();
            $table->foreign('lib_asrh_algorithm_code')->references('code')->on('lib_asrh_algorithms')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lib_questionnaire_algorithm_pivot');
    }
};
