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
        Schema::create('patient_fp_methods', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignUlid('patient_fp_id')->index()->constrained('patient_fp');
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();
            $table->string('method_code')->index();
            $table->date('enrollment_date');
            $table->char('client_code', 10)->index();
            $table->string('treatment_partner');
            $table->text('permanent_reason')->nullable();
            $table->date('dropout_date')->nullable();
            $table->unsignedBigInteger('dropout_reason_code')->nullable()->index();
            $table->text('dropout_remarks')->nullable();
            $table->boolean('dropout_flag');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('method_code')->references('code')->on('lib_fp_methods');
            $table->foreign('client_code')->references('code')->on('lib_fp_client_types');
            $table->foreign('dropout_reason_code')->references('code')->on('lib_fp_dropout_reasons');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_fp_methods');
    }
};
