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
        Schema::table('lib_ncd_risk_stratifications', function (Blueprint $table) {
            $table->char('konsulta_risk_stratifcation_id')->nullable()->after('risk_color');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lib_ncd_risk_stratifications', function (Blueprint $table) {
            $table->dropColumn('konsulta_risk_stratifcation_id');
        });
    }
};
