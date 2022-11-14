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
        Schema::create('consult_notes_complaints', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notes_id')->constrained();
            $table->unsignedBigInteger('consult_id')->constrained();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->string('complaint_id')->constrained();
            // $table->date('complaint_date');
            $table->foreignUuid('user_id')->index()->constrained();
            $table->timestamps();

            $table->foreign('notes_id')->references('id')->on('consult_notes');
            $table->foreign('consult_id')->references('id')->on('consults');
            $table->foreign('complaint_id')->references('complaint_id')->on('lib_complaints');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consult_notes_complaints');
    }
};
