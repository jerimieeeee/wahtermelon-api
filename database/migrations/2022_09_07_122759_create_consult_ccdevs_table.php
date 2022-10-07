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
        Schema::create('consult_ccdevs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id')->constrained();
            $table->integer('user_id');
            $table->dateTime('visit_date');
            $table->boolean('visit_ended');
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('ccdevs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consult_ccdevs');
    }
};
