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
        Schema::table('consult_mc_services', function (Blueprint $table) {
            $table->string('facility_code')->index()->after('patient_mc_id');
            $table->char('service_id',10)->change();
            $table->boolean('positive_result')->nullable()->change();
            $table->boolean('intake_penicillin')->nullable()->change();
            $table->dropColumn('visit_type');
            $table->char('visit_type_code', 10)->after('service_id');

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('service_id')->references('id')->on('lib_mc_services');
            $table->foreign('visit_type_code')->references('code')->on('lib_mc_visit_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('consult_mc_services', function (Blueprint $table) {
            $table->char('visit_type',10);
            $table->dropForeign(['visit_type_code']);
            $table->dropColumn('visit_type_code');

            $table->dropForeign(['facility_code']);
            $table->dropColumn('facility_code');

            $table->dropForeign(['service_id']);
            $table->char('service_id',5)->change();

            $table->boolean('positive_result')->nullable(0)->change();
            $table->boolean('intake_penicillin')->nullable(0)->change();

        });
        Schema::enableForeignKeyConstraints();
    }
};
