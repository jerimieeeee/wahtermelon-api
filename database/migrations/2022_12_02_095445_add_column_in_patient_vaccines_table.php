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
        Schema::table('patient_vaccines', function (Blueprint $table) {
            $table->string('facility_code')->index()->after('user_id')->nullable();
            $table->foreign('facility_code')->references('code')->on('facilities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_vaccines', function (Blueprint $table) {
            $table->dropForeign('facility_code');
            $table->dropColumn('facility_code');
        });
    }
};
