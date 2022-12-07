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
        Schema::table('consult_ccdev_breastfeds', function(Blueprint $table) {
            $table->renameColumn('patient_ccdevs_id', 'patient_ccdev_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consult_ccdev_breastfeds', function(Blueprint $table) {
            $table->renameColumn('patient_ccdev_id', 'patient_ccdevs_id');
        });
    }
};
