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
        Schema::create('consult_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consult_id')->constrained;
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('complaint', 255)->nullable();
            $table->text('history', 255)->nullable();
            $table->string('physical_exam', 255)->nullable();
            $table->string('plan', 255)->nullable();
            $table->timestamps();

            $table->foreign('consult_id')->references('id')->on('consults');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consult_notes');
    }
};
