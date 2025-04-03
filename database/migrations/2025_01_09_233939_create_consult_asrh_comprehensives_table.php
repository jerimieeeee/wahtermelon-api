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
        Schema::create('consult_asrh_comprehensives', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignUlid('consult_asrh_rapid_id')->index()->constrained()->cascadeOnDelete();
            $table->string('facility_code')->index();
            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->date('assessment_date')->index();
            $table->boolean('consent_flag')->default(false);
            $table->text('home_notes')->nullable();
            $table->text('education_notes')->nullable();
            $table->text('eating_notes')->nullable();
            $table->text('activities_notes')->nullable();
            $table->text('drugs_notes')->nullable();
            $table->text('sexuality_notes')->nullable();
            $table->text('suicide_notes')->nullable();
            $table->text('safety_notes')->nullable();
            $table->text('spirituality_notes')->nullable();
            $table->boolean('risky_behavior')->default(0)->nullable(1);
            $table->boolean('seriously_injured')->default(0)->nullable(1);
            $table->enum('status', ['done', 'refused'])->nullable(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consult_asrh_comprehensives');
    }
};
