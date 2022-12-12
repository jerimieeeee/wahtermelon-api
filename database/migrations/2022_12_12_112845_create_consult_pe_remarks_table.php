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
        Schema::create('consult_pe_remarks', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->unsignedBigInteger('notes_id')->constrained();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();
            $table->string('skin_remarks')->nullable();
            $table->string('heent_remarks')->nullable();
            $table->string('chest_remarks')->nullable();
            $table->string('heart_remarks')->nullable();
            $table->string('neuro_remarks')->nullable();
            $table->string('rectal_remarks')->nullable();
            $table->string('genitourinary_remarks')->nullable();
            $table->timestamps();

            $table->foreign('notes_id')->references('id')->on('consult_notes');
            $table->foreign('facility_code')->references('code')->on('facilities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consult_pe_remarks');
    }
};
