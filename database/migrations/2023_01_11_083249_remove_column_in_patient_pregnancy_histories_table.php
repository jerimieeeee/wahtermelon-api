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
        Schema::table('patient_pregnancy_histories', function (Blueprint $table) {
            $table->dropForeign(['pregnancy_history_applicable']);
            $table->dropColumn('pregnancy_history_applicable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_pregnancy_histories', function (Blueprint $table) {
            $table->char('pregnancy_history_applicable', 10)->index()->nullable()->after('with_family_planning');
            $table->foreign('pregnancy_history_applicable')->references('id')->on('lib_ncd_answer_s2');
        });
    }
};
