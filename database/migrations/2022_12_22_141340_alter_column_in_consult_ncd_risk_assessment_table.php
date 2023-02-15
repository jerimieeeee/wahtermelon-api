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
        Schema::table('consult_ncd_risk_assessment', function (Blueprint $table) {
            $table->unsignedBigInteger('client_type')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consult_ncd_risk_assessment', function (Blueprint $table) {
            $table->unsignedBigInteger('client_type')->nullable(false)->change();
        });
    }
};
