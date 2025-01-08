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
        Schema::create('consult_asrh_rapids', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->string('facility_code')->index();
            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->date('assessment_date')->index();
            $table->date('end_date')->index()->nullable();
            $table->enum('client_type', ['walk-in', 'referred'])->default('walk-in');
            $table->char('lib_asrh_client_type_code', 10)->nullable(1);
            $table->string('other_client_type')->nullable();
            $table->foreign('lib_asrh_client_type_code')->references('code')->on('lib_asrh_client_types');
            $table->boolean('consent_flag')->default(false);
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consult_asrh_rapids');
    }
};
