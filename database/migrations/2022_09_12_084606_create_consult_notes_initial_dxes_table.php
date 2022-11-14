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
        Schema::create('consult_notes_initial_dxes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notes_id')->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->integer('class_id')->constrained();
            $table->string('idx_remark', 255)->nullable();
            $table->timestamps();

            $table->foreign('notes_id')->references('id')->on('consult_notes');
            $table->foreign('class_id')->references('class_id')->on('lib_diagnoses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consult_notes_initial_dxes');
    }
};
