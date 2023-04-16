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
        Schema::table('konsulta_transmittals', function (Blueprint $table) {
            $table->unsignedInteger('tranche')->nullable()->after('transmittal_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('konsulta_transmittals', function (Blueprint $table) {
            $table->dropColumn('tranche');
        });
    }
};
