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
        Schema::create('patient_gbv_placements', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();
            $table->foreignUlid('patient_gbv_id')->index()->constrained();
            $table->foreignId('location_id')->index()->nullable()->constrained('lib_gbv_placement_locations');
            $table->boolean('home_by_cpu_flag')->index()->nullable();
            $table->string('home_by_other_name')->nullable();
            $table->date('scheduled_date')->nullable();
            $table->date('actual_date')->nullable();
            $table->string('placement_name')->nullable();
            $table->string('placement_contact_info', 13);
            $table->foreignId('type_id')->index()->nullable()->constrained('lib_gbv_placement_types');
            $table->string('hospital_name')->nullable();
            $table->string('hospital_ward')->nullable();
            $table->date('hospital_date_in')->nullable();
            $table->date('hospital_date_out')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_gbv_placements');
    }
};
