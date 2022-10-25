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
        Schema::create('patient_ccdevs', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->decimal('birth_weight');
            $table->boolean('ccdev_ended');
            $table->uuid('mothers_id')->index()->constrained();
            $table->dateTime('admission_date');
            $table->dateTime('discharge_date');
            $table->string('nbs_filter', 50);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('mothers_id')->references('id')->on('patients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_ccdevs');
    }
};
