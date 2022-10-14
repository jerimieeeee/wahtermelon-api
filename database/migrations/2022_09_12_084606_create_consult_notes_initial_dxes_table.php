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
            $table->unsignedBigInteger('notes_id')->constrained;
            $table->foreignUuid('user_id')->index()->constrained();
            $table->integer('class_id');
            $table->string('dx_remarks', 255);
            $table->timestamps();

            $table->foreign('notes_id')->references('id')->on('consult_notes');
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
