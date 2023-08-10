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
        Schema::create('patient_ab_exposures', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();

            $table->foreignUlid('patient_ab_id')->constrained();
            $table->foreignId('animal_type_id')->on('lib_ab_animal_types');
            $table->string('animal_type_remarks')->nullable();
            $table->string('exposure_place')->nullable();
            $table->boolean('bite_flag')->default(false);
            $table->foreignId('animal_ownership_id')->on('lib_ab_animal_ownerships');

            $table->boolean('feet_flag')->default(false);
            $table->boolean('leg_flag')->default(false);
            $table->boolean('arms_flag')->default(false);
            $table->boolean('hand_flag')->default(false);
            $table->boolean('knee_flag')->default(false);
            $table->boolean('neck_flag')->default(false);
            $table->boolean('head_flag')->default(false);
            $table->boolean('others_flag')->default(false);
            $table->string('al_remarks')->nullable();
            $table->string('exposure_type_code');
            $table->boolean('wash_flag')->default(false);
            $table->boolean('pep_flag')->default(false);
            $table->string('remarks')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('exposure_type_code')->references('code')->on('lib_ab_exposure_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_ab_exposures');
    }
};
