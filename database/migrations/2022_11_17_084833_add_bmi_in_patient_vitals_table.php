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
            $table->decimal('patient_bmi',10,1)->nullable()->index()->after('patient_weight');
            $table->string('patient_bmi_class',30)->nullable()->index()->after('patient_bmi');
            $table->string('patient_weight_for_age',30)->nullable()->index()->after('patient_bmi_class');
            $table->string('patient_height_for_age',30)->nullable()->index()->after('patient_weight_for_age');
            $table->string('patient_weight_for_height',30)->nullable()->index()->after('patient_height_for_age');
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
            $table->dropColumn('patient_bmi');
            $table->dropColumn('patient_bmi_class');
            $table->dropColumn('patient_weight_for_age');
            $table->dropColumn('patient_height_for_age');
            $table->dropColumn('patient_weight_for_height');
        });
    }
};
