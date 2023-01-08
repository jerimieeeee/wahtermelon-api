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
        Schema::table('consult_laboratories', function (Blueprint $table) {
            $table->char('recommendation_code',10)->index()->nullable()->default('Y')->after('lab_code');
            $table->char('request_status_code',10)->index()->nullable()->default('RQ')->after('recommendation_code');

            $table->foreign('recommendation_code')->references('code')->on('lib_laboratory_recommendations');
            $table->foreign('request_status_code')->references('code')->on('lib_laboratory_request_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consult_laboratories', function (Blueprint $table) {
            $table->dropForeign(['recommendation_code']);
            $table->dropForeign(['request_status_code']);
            $table->dropColumn(['recommendation_code', 'request_status_code']);
        });
    }
};
