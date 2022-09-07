<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('facility_code')->unique();
            $table->string('short_code')->unique();
            $table->string('facility_name');
            $table->string('old_facility_name_1')->nullable();
            $table->string('old_facility_name_2')->nullable();
            $table->string('old_facility_name_3')->nullable();
            $table->string('facility_major_type');
            $table->string('health_facility_type');
            $table->string('ownership_classification')->nullable();
            $table->string('ownership_sub_classification')->nullable();
            $table->foreignId('region_id')->constrained();
            $table->foreignId('province_id')->constrained();
            $table->foreignId('municipality_id')->constrained();
            $table->foreignId('barangay_id')->nullable()->constrained();
            $table->string('service_capability')->nullable();
            $table->bigInteger('bed_capacity')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facilities');
    }
};
