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
            $table->foreignUuid('patient_id')->constrained()->index();
            $table->foreignUuid('user_id');
            $table->decimal('birth_weight');
            $table->foreignUuid('mothers_id');
            $table->boolean('ccdev_ended');
            $table->dateTime('admission_date');
            $table->dateTime('discharge_date');
            $table->softDeletes();
            $table->timestamps();
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
