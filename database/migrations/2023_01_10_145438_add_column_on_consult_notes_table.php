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
        Schema::table('consult_notes', function (Blueprint $table) {
            $table->char('general_survey_code')->nullable()->after('plan');
            $table->string('general_survey_remarks')->nullable()->after('general_survey_code');

            $table->foreign('general_survey_code')->references('code')->on('lib_general_surveys');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consult_notes', function (Blueprint $table) {
            $table->dropForeign(['general_survey_code']);
            $table->dropColumn('general_survey_code');
            $table->dropColumn('general_survey_remarks');
        });
    }
};
