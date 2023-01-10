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
        Schema::table('patient_vitals', function (Blueprint $table) {
            $table->integer('patient_left_vision_acuity')->index()->after('patient_muac')->nullable();
            $table->integer('patient_right_vision_acuity')->index()->after('patient_left_vision_acuity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_vitals', function (Blueprint $table) {
            $table->dropColumn('patient_left_vision_acuity');
            $table->dropColumn('patient_right_vision_acuity');
        });
    }
};
