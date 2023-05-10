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
        Schema::create('patient_gbv_interviews', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();
            $table->foreignUlid('patient_gbv_id')->index()->constrained();
            $table->char('info_source_code')->nullable();
            $table->dateTime('incident_first_datetime')->nullable();
            $table->text('incident_first_remarks')->nullable();
            $table->dateTime('incident_recent_datetime')->nullable();
            $table->text('incident_recent_remarks')->nullable();
            $table->char('disclosed_flag')->nullable()->constrained();
            $table->foreignId('disclosed_type')->nullable()->constrained('lib_gbv_disclosed_types');
            $table->foreignId('abused_episode_id')->nullable()->constrained('lib_gbv_abused_episodes');
            $table->unsignedInteger('abused_episode_count')->nullable();
            $table->foreignId('abused_site_id')->nullable()->constrained('lib_gbv_abused_sites');
            $table->text('abused_site_remarks')->nullable();
            $table->text('abused_site_remarks_address')->nullable();
            $table->text('initial_disclosure')->nullable();
            $table->boolean('witnessed_flag')->nullable();
            $table->foreignId('relation_to_child')->nullable()->constrained('lib_gbv_child_relations');
            $table->foreignId('child_behavior_id')->nullable()->constrained('lib_gbv_child_behaviors');
            $table->text('child_behavior_remarks')->nullable();
            $table->text('dev_screening_remarks')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('info_source_code')->references('code')->on('lib_answer_yn');
            $table->foreign('disclosed_flag')->references('code')->on('lib_answer_ynx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_gbv_interviews');
    }
};
