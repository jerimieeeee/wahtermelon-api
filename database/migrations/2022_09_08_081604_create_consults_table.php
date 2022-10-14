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
        Schema::create('consults', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->timestamps();
            $table->dateTime('consult_end');
            $table->integer('physician_id');
            $table->boolean('is_pregnant');
            $table->boolean('consult_done');
            // $table->boolean('old_data', 1);
            // $table->boolean('pdf_created', 1);
            // $table->string('pHospitalTransmittalNo', 20);
            $table->char('ptgroup', 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consults');
    }
};
