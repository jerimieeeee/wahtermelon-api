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
            $table->decimal('patient_head_circumference',10,2)->nullable()->index()->after('patient_weight');
            $table->decimal('patient_skinfold_thickness',10,2)->nullable()->index()->after('patient_head_circumference');
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
            $table->dropColumn('patient_head_circumference');
            $table->dropColumn('patient_skinfold_thickness');
        });
    }
};
