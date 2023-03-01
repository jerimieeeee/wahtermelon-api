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
        Schema::table('consult_laboratory_rbs', function (Blueprint $table) {
            $table->string('referral_facility')->nullable()->index()->after('laboratory_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consult_laboratory_rbs', function (Blueprint $table) {
            $table->dropColumn('referral_facility');
        });
    }
};
