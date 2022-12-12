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
            $table->renameColumn('breast_screen', 'breast_code');

            $table->dropColumn('remarks');
            $table->dropColumn('breast_remarks');
            $table->dropColumn('chest_remarks');
            $table->dropColumn('heent_remarks');
            $table->dropColumn('heart_remarks');
            $table->dropColumn('abdome_remarks');
            $table->dropColumn('extremities_remarks');

            $table->uuid('id')->index()->primary()->first();

            $table->string('facility_code')->index()->nullable()->after('user_id');
            $table->string('neuro_code')->nullable()->after('extremities_code');
            $table->string('pelvic_code')->nullable()->after('neuro_code');
            $table->string('genitourinary_code')->nullable()->after('pelvic_code');
            $table->timestamps();

            $table->foreign('notes_id')->references('id')->on('consult_notes');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('breast_code')->references('pe_id')->on('lib_pes');
            $table->foreign('skin_code')->references('pe_id')->on('lib_pes');
            $table->foreign('heent_code')->references('pe_id')->on('lib_pes');
            $table->foreign('chest_code')->references('pe_id')->on('lib_pes');
            $table->foreign('heart_code')->references('pe_id')->on('lib_pes');
            $table->foreign('extremities_code')->references('pe_id')->on('lib_pes');
            $table->foreign('abdomen_code')->references('pe_id')->on('lib_pes');
            $table->foreign('neuro_code')->references('pe_id')->on('lib_pes');
            $table->foreign('pelvic_code')->references('pe_id')->on('lib_pes');
            $table->foreign('genitourinary_code')->references('pe_id')->on('lib_pes');
            $table->foreign('facility_code')->references('code')->on('facilities');
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
            $table->dropForeign(['user_id']);
            $table->dropForeign(['breast_code']);
            $table->dropForeign(['skin_code']);
            $table->dropForeign(['heent_code']);
            $table->dropForeign(['chest_code']);
            $table->dropForeign(['heart_code']);
            $table->dropForeign(['extremities_code']);
            $table->dropForeign(['abdomen_code']);
            $table->dropForeign(['neuro_code']);
            $table->dropForeign(['pelvic_code']);
            $table->dropForeign(['genitourinary_code']);
            $table->dropForeign(['facility_code']);
            $table->dropColumn('neuro_code');
            $table->dropColumn('pelvic_code');
            $table->dropColumn('genitourinary_code');
            $table->dropColumn('facility_code');
            $table->dropColumn('id');
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');

            $table->renameColumn('breast_code', 'breast_screen');

            $table->string('remarks');
            $table->string('breast_remarks');
            $table->string('heent_remarks');
            $table->string('chest_remarks');
            $table->string('heart_remarks');
            $table->string('abdome_remarks');
            $table->string('extremities_remarks');

        });
    }
};
