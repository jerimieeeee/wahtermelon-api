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
        Schema::create('patient_washington_questions', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();

            $table->foreignId('difficulty_seeing')->nullable()->constrained('lib_washington_disability_answers');
            $table->foreignId('difficulty_hearing')->nullable()->constrained('lib_washington_disability_answers');
            $table->foreignId('difficulty_walking')->nullable()->constrained('lib_washington_disability_answers');
            $table->foreignId('difficulty_remembering')->nullable()->constrained('lib_washington_disability_answers');
            $table->foreignId('difficulty_self_care')->nullable()->constrained('lib_washington_disability_answers');
            $table->foreignId('difficulty_speaking')->nullable()->constrained('lib_washington_disability_answers');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_washington_questions');
    }
};
