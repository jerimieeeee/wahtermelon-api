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
        Schema::create('patient_ab_post_exposures', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();

            $table->foreignUlid('patient_ab_id')->constrained();

            $table->decimal('weight', 10, 2)->nullable();
            $table->string('animal_status_code');
            $table->date('animal_status_date')->nullable();
            $table->string('rig_type_code');
            $table->date('rig_date')->nullable();
            $table->boolean('booster_1_flag')->default(false);
            $table->boolean('booster_2_flag')->default(false);
            $table->date('other_vacc_date')->nullable();
            $table->string('other_vacc_desc')->nullable();
            $table->char('other_vacc_route_code', 2)->nullable();

            $table->date('day0_date')->nullable();
            $table->string('day0_vaccine_code')->nullable();
            $table->char('day0_vaccine_route_code', 2)->nullable();
            $table->date('day3_date')->nullable();
            $table->string('day3_vaccine_code')->nullable();
            $table->char('day3_vaccine_route_code', 2)->nullable();
            $table->date('day7_date')->nullable();
            $table->string('day7_vaccine_code')->nullable();
            $table->char('day7_vaccine_route_code', 2)->nullable();
            $table->date('day14_date')->nullable();
            $table->string('day14_vaccine_code')->nullable();
            $table->char('day14_vaccine_route_code', 2)->nullable();
            $table->date('day28_date')->nullable();
            $table->string('day28_vaccine_code')->nullable();
            $table->char('day28_vaccine_route_code', 2)->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('animal_status_code')->references('code')->on('lib_ab_animal_statuses');
            $table->foreign('rig_type_code')->references('code')->on('lib_ab_rig_types');
            $table->foreign('other_vacc_route_code')->references('code')->on('lib_ab_vaccine_routes');
            // lib_ab_vaccines
            $table->foreign('day0_vaccine_code')->references('code')->on('lib_ab_vaccines');
            $table->foreign('day0_vaccine_route_code')->references('code')->on('lib_ab_vaccine_routes');
            $table->foreign('day3_vaccine_code')->references('code')->on('lib_ab_vaccines');
            $table->foreign('day3_vaccine_route_code')->references('code')->on('lib_ab_vaccine_routes');
            $table->foreign('day7_vaccine_code')->references('code')->on('lib_ab_vaccines');
            $table->foreign('day7_vaccine_route_code')->references('code')->on('lib_ab_vaccine_routes');
            $table->foreign('day14_vaccine_code')->references('code')->on('lib_ab_vaccines');
            $table->foreign('day14_vaccine_route_code')->references('code')->on('lib_ab_vaccine_routes');
            $table->foreign('day28_vaccine_code')->references('code')->on('lib_ab_vaccines');
            $table->foreign('day28_vaccine_route_code')->references('code')->on('lib_ab_vaccine_routes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_ab_post_exposures');
    }
};
