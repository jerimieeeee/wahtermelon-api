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
        Schema::create('philhealth_credentials', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->string('facility_code')->index();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->char('program_code', 10)->index();
            $table->string('facility_name')->index();
            $table->string('accreditation_number')->index();
            $table->string('pmcc_number')->index();
            $table->string('software_certification_id')->index();
            $table->string('cipher_key')->index();
            $table->string('username')->index();
            $table->string('password')->index();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('program_code')->references('code')->on('lib_philhealth_programs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('philhealth_credentials');
    }
};
