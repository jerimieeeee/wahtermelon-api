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
        Schema::create('consult_notes_final_dxes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notes_id')->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('icd10_code', 50)->constrained();
            $table->string('fdx_remark', 255)->nullable();
            $table->timestamps();

            $table->foreign('notes_id')->references('id')->on('consult_notes');
            $table->foreign('icd10_code')->references('icd10_code')->on('lib_icd10s');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consult_notes_final_dxes');
    }
};
