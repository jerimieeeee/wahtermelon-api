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
        Schema::create('patient_tb_symptoms', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();

            $table->boolean('bcpain')->default(0);
            $table->boolean('cough')->default(0);
            $table->boolean('drest')->default(0);
            $table->boolean('dexertion')->default(0);
            $table->boolean('fever')->default(0);
            $table->boolean('hemoptysis')->default(0);
            $table->boolean('nsweats')->default(0);
            $table->boolean('pedema')->default(0);
            $table->boolean('wloss')->default(0);
            $table->string('symptoms_remarks')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_tb_symptoms');
    }
};
