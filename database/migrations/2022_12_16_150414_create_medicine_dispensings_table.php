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
        Schema::create('medicine_dispensings', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->string('facility_code')->index();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->date('dispensing_date')->index();
            $table->foreignUuid('prescription_id')->nullable()->index()->constrained('medicine_prescriptions');
            $table->unsignedInteger('dispense_quantity');
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->string('remarks');
            $table->softDeletes();
            $table->timestamps();

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
        Schema::dropIfExists('medicine_dispensings');
    }
};
