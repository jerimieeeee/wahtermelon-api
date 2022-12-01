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
            $table->decimal('patient_chest',10,2)->nullable()->index()->after('patient_pulse_rate');
            $table->decimal('patient_abdomen',10,2)->nullable()->index()->after('patient_chest');
            $table->unsignedInteger('patient_spo2')->nullable()->index()->after('patient_pulse_rate');
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
            $table->dropColumn('patient_chest');
            $table->dropColumn('patient_abdomen');
            $table->dropColumn('patient_spo2');
        });
    }
};
