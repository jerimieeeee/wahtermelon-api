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
        Schema::create('consult_notes_pes', function (Blueprint $table) {
            $table->unsignedBigInteger('notes_id')->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('remarks', 255);
            $table->string('breast_screen', 10);
            $table->string('breast_remarks', 255);
            $table->string('skin_code', 255);
            $table->string('heent_code', 100);
            $table->string('heent_remarks', 255);
            $table->string('chest_code', 100);
            $table->string('chest_remarks', 255);
            $table->string('heart_code', 100);
            $table->string('heart_remarks', 255);
            $table->string('abdomen_code', 100);
            $table->string('abdome_remarks', 255);
            $table->string('extremities_code', 100);
            $table->string('extremities_remarks', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consult_notes_pes');
    }
};
