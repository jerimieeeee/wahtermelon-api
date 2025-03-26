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
        Schema::create('consult_asrh_rapid_answers', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignUlid('consult_asrh_rapid_id')->index()->constrained()->cascadeOnDelete();
            $table->string('facility_code')->index();
            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->foreignId('lib_rapid_questionnaire_id')->index()->constrained('lib_rapid_questionnaires');
            $table->enum('answer', ['1', '2', 'x'])->default('x');
            $table->text('remarks')->nullable(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consult_asrh_rapid_answers');
    }
};
