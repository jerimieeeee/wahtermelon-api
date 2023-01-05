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
        Schema::table('patient_social_histories', function (Blueprint $table) {
            $table->string('sexually_active')->nullable()->after('illicit_drugs');
            $table->foreign('sexually_active')->references('id')->on('lib_ncd_answer_s2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_social_histories', function (Blueprint $table) {
            $table->dropForeign(['sexually_active']);
            $table->dropColumn('sexually_active');
        });
    }
};
