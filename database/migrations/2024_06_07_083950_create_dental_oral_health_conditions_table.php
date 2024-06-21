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
        Schema::create('dental_oral_health_conditions', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->string('facility_code')->index();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignId('consult_id')->nullable()->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();

            $table->boolean('healthy_gums_flag')->default(false);
            $table->boolean('orally_fit_flag')->default(false);
            $table->boolean('oral_rehab_flag')->default(false);
            $table->boolean('dental_caries_flag')->default(false);
            $table->boolean('gingivitis_flag')->default(false);
            $table->boolean('periodontal_flag')->default(false);
            $table->boolean('debris_flag')->default(false);
            $table->boolean('calculus_flag')->default(false);
            $table->boolean('abnormal_growth_flag')->default(false);
            $table->boolean('cleft_lip_flag')->default(false);
            $table->boolean('supernumerary_flag')->default(false);
            $table->boolean('dento_facial_flag')->default(false);
            $table->boolean('others_flag')->default(false);
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('dental_oral_health_conditions');
    }
};
