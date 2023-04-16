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
        Schema::table('consult_ccdev_services', function (Blueprint $table) {
            $table->unsignedBigInteger('status_id')->nullable()->index()->constrained()->after('service_date');

            $table->foreign('status_id')->references('status_id')->on('lib_vaccine_statuses');
            $table->foreign('service_id')->references('service_id')->on('lib_ccdev_services');
        });

        Schema::table('consult_ccdev_services', function (Blueprint $table) {
            $table->date('service_date')->nullable()->change();
        });

        Schema::table('consult_ccdev_services', function (Blueprint $table) {
            $table->dropForeign(['patient_ccdevs_id']);
            $table->dropColumn('patient_ccdevs_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consult_ccdev_services', function (Blueprint $table) {
            $table->dropForeign(['status_id']);
            $table->dropForeign(['service_id']);
            $table->dropColumn('status_id');
        });

        Schema::table('consult_ccdev_services', function (Blueprint $table) {
            $table->unsignedBigInteger('patient_ccdevs_id')->index()->constrained()->after('id');
            $table->foreign('patient_ccdevs_id')->references('id')->on('patient_ccdevs');
        });

        Schema::table('consult_ccdev_services', function (Blueprint $table) {
            $table->date('service_date')->nullable(false)->change();
        });
    }
};
