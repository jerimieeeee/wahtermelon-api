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
        Schema::create('eclaims_caserate_lists', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->string('facility_code')->index();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();

            $table->string('program_desc');
            $table->string('program_id');
            $table->string('admit_dx');
            $table->date('caserate_date');
            $table->string('caserate_code');
            $table->string('code');
            $table->string('description');
            $table->decimal('hci_fee', 7, 2);
            $table->decimal('prof_fee', 7, 2);
            $table->decimal('caserate_fee', 7, 2);
            $table->string('caserate_attendant');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('program_id')->references('id')->on('lib_pt_groups');
            $table->foreign('caserate_attendant')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eclaims_caserate_lists');
    }
};
