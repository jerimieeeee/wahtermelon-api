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
        Schema::create('consult_ccdev_vaccines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_ccdev_id')->index()->constrained();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('vaccine_id', 10)->index()->constrained();
            $table->date('vaccine_date')->nullable();
            $table->timestamps();

            $table->foreign('vaccine_id')->references('vaccine_id')->on('lib_vaccines');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consult_ccdev_vaccines');
    }
};
