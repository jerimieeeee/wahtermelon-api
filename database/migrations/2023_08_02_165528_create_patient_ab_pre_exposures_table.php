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
        Schema::create('patient_ab_pre_exposures', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();
            $table->foreignUlid('patient_ab_id')->constrained();

            $table->string('indication_option_code', 6);
            $table->string('indication_option_remarks');
            $table->date('day0_date')->nullable();
            $table->string('day0_vaccine_code')->nullable();
            $table->char('day0_vaccine_route_code', 2)->nullable();
            $table->date('day7_date')->nullable();
            $table->string('day7_vaccine_code')->nullable();
            $table->char('day7_vaccine_route_code', 2)->nullable();
            $table->date('day21_date')->nullable();
            $table->string('day21_vaccine_code')->nullable();
            $table->char('day21_vaccine_route_code', 2)->nullable();
            $table->string('remarks')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('indication_option_code')->references('code')->on('lib_ab_indication_options');
            $table->foreign('day0_vaccine_code')->references('code')->on('lib_ab_vaccines');
            $table->foreign('day0_vaccine_route_code')->references('code')->on('lib_ab_vaccine_routes');
            $table->foreign('day7_vaccine_code')->references('code')->on('lib_ab_vaccines');
            $table->foreign('day7_vaccine_route_code')->references('code')->on('lib_ab_vaccine_routes');
            $table->foreign('day21_vaccine_code')->references('code')->on('lib_ab_vaccines');
            $table->foreign('day21_vaccine_route_code')->references('code')->on('lib_ab_vaccine_routes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_ab_pre_exposures');
    }
};
