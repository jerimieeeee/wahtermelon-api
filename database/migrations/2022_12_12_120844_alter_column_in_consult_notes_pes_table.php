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
        Schema::table('consult_notes_pes', function (Blueprint $table) {
            $table->dropColumn('remarks');
            $table->dropColumn('breast_screen');
            $table->dropColumn('breast_remarks');
            $table->dropColumn('skin_code');
            $table->dropColumn('heent_code');
            $table->dropColumn('heent_remarks');
            $table->dropColumn('chest_code');
            $table->dropColumn('chest_remarks');
            $table->dropColumn('heart_code');
            $table->dropColumn('heart_remarks');
            $table->dropColumn('abdomen_code');
            $table->dropColumn('abdome_remarks');
            $table->dropColumn('extremities_code');
            $table->dropColumn('extremities_remarks');

            $table->uuid('id')->index()->primary()->first();
            $table->string('pe_id')->nullable();

            $table->string('facility_code')->index()->nullable()->after('user_id');
            $table->timestamps();

            $table->foreign('notes_id')->references('id')->on('consult_notes');
            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('pe_id')->references('pe_id')->on('lib_pes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consult_notes_pes', function (Blueprint $table) {
            $table->dropForeign(['notes_id']);
            $table->dropForeign(['facility_code']);
            $table->dropForeign(['pe_id']);

            $table->dropColumn('facility_code');
            $table->dropColumn('pe_id');
            $table->dropColumn('id');
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');

            $table->string('remarks');
            $table->string('breast_screen');
            $table->string('breast_remarks');
            $table->string('skin_code');
            $table->string('heent_code');
            $table->string('heent_remarks');
            $table->string('chest_code');
            $table->string('chest_remarks');
            $table->string('heart_code');
            $table->string('heart_remarks');
            $table->string('abdomen_code');
            $table->string('abdome_remarks');
            $table->string('extremities_code');
            $table->string('extremities_remarks');
        });
    }
};
