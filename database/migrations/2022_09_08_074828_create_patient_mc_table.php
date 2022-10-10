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
        Schema::create('patient_mc', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->string('facility_code')->index();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->unsignedInteger('patient_age');
            $table->unsignedInteger('patient_height');
            $table->date('pregnancy_termination_date')->nullable();
            $table->char('pregnancy_termination_code')->nullable()->index();
            $table->string('pregnancy_termination_cause')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');

            $table->foreign('pregnancy_termination_code')->references('code')->on('lib_mc_pregnancy_terminations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_mc');
    }
};
