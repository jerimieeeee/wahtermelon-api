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
        Schema::table('consult_ncd_risk_screening_glucose', function (Blueprint $table) {
            $table->char('fbs')->nullable()->change();
            $table->char('rbs')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consult_ncd_risk_screening_glucose', function (Blueprint $table) {
            $table->char('fbs')->nullable(false)->change();
            $table->char('rbs')->nullable(false)->change();
        });
    }
};
