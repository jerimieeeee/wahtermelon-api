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
        Schema::table('consult_ccdev_breastfeds', function (Blueprint $table) {
            $table->date('comp_fed_date')->nullable()->after('ebf_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consult_ccdev_breastfeds', function (Blueprint $table) {
            $table->dropColumn('comp_fed_date');
        });
    }
};
