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
        Schema::table('consult_laboratory_oral_glucose', function (Blueprint $table) {
            $table->dropColumn('date_added');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consult_laboratory_oral_glucose', function (Blueprint $table) {
            $table->date('date_added')->index()->after('ogtt_two_hour_mmol')->nullable();
        });
    }
};
