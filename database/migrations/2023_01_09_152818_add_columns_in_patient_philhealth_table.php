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
        Schema::table('patient_philhealth', function (Blueprint $table) {
            $table->string('transmittal_number', 21)->unique()->index()->nullable()->after('transaction_number');
            $table->string('authorization_transaction_code', 21)->default('WALKEDIN')->index()->nullable()->after('employer_address');
            $table->boolean('walkedin_status')->index()->default(1)->after('authorization_transaction_code');

            $table->foreign('transmittal_number')->references('transmittal_number')->on('konsulta_transmittals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_philhealth', function (Blueprint $table) {
            $table->dropForeign(['transmittal_number']);
            $table->dropColumn(['authorization_transaction_code', 'walkedin_status', 'transmittal_number']);
        });
    }
};
