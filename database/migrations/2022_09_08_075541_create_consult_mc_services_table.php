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
        Schema::create('consult_mc_services', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->uuid('patient_mc_id');
            // $table->foreignId('consult_id')->constrained();
            $table->foreignUuid('patient_id')->constrained();
            $table->foreignUuid('user_id')->constrained();
            $table->char('service_id', 5);
            $table->char('visit_type', 10);
            $table->char('visit_status', 10);
            $table->date('service_date');
            $table->unsignedInteger('service_qty')->nullable();
            $table->boolean('positive_result');
            $table->boolean('intake_penicillin');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('patient_mc_id')->references('id')->on('patient_mc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consult_mc_services');
    }
};
