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
        Schema::create('eclaims_uploads', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();
            $table->foreignUlid('eclaims_caserate_list_id');
            $table->string('pHospitalTransmittalNo', 21);
            $table->string('pTransmissionControlNumber', 18)->nullable();
            $table->string('pReceiptTicketNumber', 18)->nullable();
            $table->string('pClaimSeriesLhio', 18)->nullable();
            $table->string('pStatus', 50)->nullable();
            $table->date('pTransmissionDate')->nullable();
            $table->time('pTransmissionTime')->nullable();
            $table->date('pCheckDate')->nullable();
            $table->char('isSuccess', 1)->nullable();
            $table->text('fail_error')->nullable();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eclaims_uploads');
    }
};
